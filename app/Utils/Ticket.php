<?php

namespace App\Utils;

use App\Models\Ticket as Model;
use App\Models\TicketDetail;
use Illuminate\Http\Request;
use Lang;
use Storage;

class Ticket
{
    public static function create(Request $request, $user_id, $admin = false, $admin_id = null)
    {
        \DB::beginTransaction();

        try {
            $ticket = new Model();
            $ticket->user_id = $user_id;
            $ticket->title = $request->post('title');
            $ticket->department_id = $request->post('department_id');
            $ticket->service_id = $request->post('service_id');
            $ticket->priority = $request->post('priority');
            $ticket->status = 1;
            $ticket->save();

            $ticket_detail = new TicketDetail();
            $ticket_detail->user_id = $admin ? $admin_id : $user_id;
            $ticket_detail->ticket_id = $ticket->id;
            $ticket_detail->content = clean($request->post('content'));
            $ticket_detail->admin = $admin;
            $ticket_detail->attachments = self::upload($request);
            $ticket_detail->save();

            \DB::commit();
            return $ticket;
        } catch (\Exception $e) {
            \DB::rollBack();
            return false;
        }
    }

    public static function reply(Request $request, $id, $uid, $admin = false)
    {
        $request->validate(['content' => 'required']);

        Model::findOrFail($id)->update(['status' => $admin ? 2 : 3]);

        $ticket_detail = new TicketDetail();
        $ticket_detail->user_id = $uid;
        $ticket_detail->ticket_id = $id;
        $ticket_detail->content = clean($request->post('content'));
        $ticket_detail->admin = $admin;
        $ticket_detail->attachments = self::upload($request);
        $ticket_detail->save();
    }

    public static function titleTrans($title)
    {
        if (Lang::has($tsn = 'ticket.status.' . str_replace(['-', ' '], '_', strtolower($title)))) {
            return Lang::get($tsn);
        } else {
            return __($title);
        }
    }

    private static function upload(Request $request)
    {
        $files = [];

        foreach (\Arr::wrap($request->file('files')) as $file) {
            if (!$file->isValid()) continue;

            $fileExtension = $file->getClientOriginalExtension();
            if (!in_array($fileExtension, json_decode(getOption('allow_upload_ext'), true)))
                continue;

            $tmpFile = $file->getRealPath();
            if (filesize($tmpFile) > getOption('max_upload_size', 2) * 1024 * 1024)
                continue;

            if (!is_uploaded_file($tmpFile))
                continue;

            $fileName = 'files/' . date('Y_m_d') . '/' .
                md5(time() . mt_rand(0, 9999)) . '.' . $fileExtension;
            if (Storage::disk('public')->put($fileName, file_get_contents($tmpFile)))
                $files[$file->getClientOriginalName()] = $fileName;
        }

        return $files;
    }
}
