package com.warungsoftware.ext

import com.warungsoftware.domain.exceptions.AuthorizationException
import org.mindrot.jbcrypt.BCrypt

class BcryptHasher{
    /**
     * Check if the password matches the User's password
     */
    fun checkPassword(plainPassword: String, hashedPassword: String) = if (BCrypt.checkpw(plainPassword, hashedPassword)) Unit
    else throw AuthorizationException("Wrong Password")

    /**
     * Returns the hashed version of the supplied password
     */
    fun hashPassword(password: String): String = BCrypt.hashpw(password, BCrypt.gensalt())
}
