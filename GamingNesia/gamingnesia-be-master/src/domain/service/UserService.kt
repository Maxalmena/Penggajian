package com.warungsoftware.domain.service

import com.warungsoftware.domain.exceptions.InvalidRequestException
import com.warungsoftware.domain.exceptions.NotFoundException
import com.warungsoftware.domain.exceptions.AuthorizationException
import com.warungsoftware.domain.repository.UserRepository
import com.warungsoftware.ext.BcryptHasher
import com.warungsoftware.ext.toUUID
import com.warungsoftware.utils.JwtProvider
import domain.model.*
import java.util.*

class UserService(
    private val bcryptHasher: BcryptHasher,
    private val jwtProvider: JwtProvider,
    private val userRepository: UserRepository
) {

    fun create(registerDto: RegisterDto): String? {
        userRepository.findByEmail(registerDto.email).apply {
            require(this == null) { throw AuthorizationException("Email already registered!") }
        }

        val user = User(
            fullName = registerDto.fullname,
            email = registerDto.email,
            password = bcryptHasher.hashPassword(registerDto.password)
        )

        userRepository.create(user)

        return generateJwToken(user)
    }

    fun update(userId: String, user: UserDto): Int {
        return userRepository.update(userId.toUUID(), user).apply {
            require(this != 0) { throw NotFoundException("user not found") }
        }
    }

    private fun generateJwToken(user: User): String? {
        return jwtProvider.createJWT(user)
    }

    fun login(loginDto: LoginDto): String? {
        val user = userRepository.findByEmail(loginDto.email).apply {
            require(this != null) { throw AuthorizationException("Email and Password doesn't exist") }
        }
        println("user: $user")
        bcryptHasher.checkPassword(loginDto.password, user?.password ?: "")

        return generateJwToken(user!!)
    }

    fun findBy(username: String) : User? {
        require(username.isNotEmpty()) { throw InvalidRequestException("username cannot be empty") }

        return userRepository.findBy(username).apply {
            require(this != null) { throw NotFoundException("user not exist") }
        }
    }

    fun getAll(): List<User> = userRepository.getAll()

    fun updateMembership(userId: String, membership: Int): User? {
        require(userId.isNotEmpty()) { throw InvalidRequestException("username cannot be empty") }

        userRepository.updateMembership(userId.toUUID(), membership).apply {
            require( this != 0) { throw NotFoundException("user not found") }
        }

        return userRepository.findBy(userId.toUUID())
    }

    fun findByEmail(email: String): User? {
        require(email.isNotEmpty()) { throw InvalidRequestException("email cannot be empty") }

        return userRepository.findByEmail(email).apply {
            require(this != null) { throw NotFoundException("user not exist") }
        }
    }

    fun findBy(userId: UUID): User? {

        return userRepository.findBy(userId).apply {
            require(this != null) { throw NotFoundException("user not exist") }
        }
    }

    fun changePassword(userId: String, changePasswordDto: ChangePasswordDto): User? {
        require(userId.isNotEmpty()) { throw InvalidRequestException("userId cannot be empty") }
        require(changePasswordDto.newPassword.isNotEmpty()) { throw InvalidRequestException("newPassword cannot be empty") }

        userRepository.findBy(userId.toUUID()).apply {
            require(this != null) { throw NotFoundException("user not exist") }
        }?.let {
            bcryptHasher.checkPassword(changePasswordDto.oldPassword, it.password)
        }

        return userRepository.updatePassword(userId.toUUID(), bcryptHasher.hashPassword(changePasswordDto.newPassword))

    }
}