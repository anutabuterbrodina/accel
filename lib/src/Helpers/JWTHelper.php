<?php

/**
 * See https://github.com/RobDWaller/ReallySimpleJWT
 */

namespace Accel\Extension\Helpers;

use ReallySimpleJWT\Token;

class JWTHelper
{
    private const SECRET = '*ABCdef8910$';

    public static function generateJWT(Payload $payload): string {
        return Token::customPayload($payload->toArray(), self::SECRET);
    }

    public static function isValid(string $token): bool {
        return Token::validate($token, self::SECRET)
            && Token::validateExpiration($token);
    }
}