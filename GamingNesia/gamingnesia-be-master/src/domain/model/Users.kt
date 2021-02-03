package domain.model

import com.warungsoftware.domain.exceptions.AuthorizationException
import com.warungsoftware.config.Exclude
import com.warungsoftware.ext.isEmailValid
import io.ktor.auth.Principal
import org.jetbrains.exposed.sql.Table

data class UserDto(
    val email: String,
    val password: String,
    val fullName: String? = "",
    val username: String? = "",
    val phoneNumber: String? = "",
    val address: String? = "",
    val profilePic: String? = "",
    val membership: Int? = 0
)

data class Auth(val authToken: String)

data class RegisterDto(val fullname: String, val email: String, val password: String)

data class LoginDto(val email: String, val password: String) {
    fun validRegister(): LoginDto {
        require(
            email.isEmailValid() ||
                    password.isNotEmpty()
        ) { throw AuthorizationException("User is not valid") }

        return LoginDto(email, password)
    }

    fun validLogin(): LoginDto {
        require(
            email.isEmailValid() ||
                    password.isNotEmpty()
        ) { throw AuthorizationException("Email or password is invalid")}

        return LoginDto(email, password)
    }
}

data class ChangePasswordDto(val oldPassword: String, val newPassword: String)

data class User(
    val id: String? = "",
    val fullName: String? = "",
    @Exclude val username: String?= "",
    val email: String,
    @Exclude val password: String,
    val phoneNumber: String? = "",
    val address: String? = "",
    val profilePic: String? = "",
    val membership: Int? = 0
): Principal

object Users: Table() {
    val id = uuid("id").autoGenerate().primaryKey()
    val fullName = varchar("full_name", 100)
    val username = varchar("username", 100)
    val email = varchar("email", 100)
    val password = varchar("password", 255)
    val phoneNumber = varchar("phone_number", 14)
    val address = varchar("address", 255)
    val profilePic = varchar("profile_pic", 255)
    val membership = integer("membership")
}