<?php

use App\Exceptions\ServiceCreateException;

return [
    ServiceCreateException::NO_SERVER_AVAILABLE => "There is no server available now.",
    ServiceCreateException::UNSUPPORTED_PERIOD => "The period you selected is unsupported."
];
