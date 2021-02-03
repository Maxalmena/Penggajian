package com.warungsoftware.domain.repository

import domain.model.LoginDto
import domain.model.User
import domain.model.UserDto
import java.util.*

interface UserRepository {

    fun findByEmail(email: String): User?

    fun create(user: User): UUID?

    fun update(userId: UUID, user: UserDto): Int

    fun findBy(username: String): User?

    fun getAll(): List<User>

    fun updateMembership(userId: UUID, membershipStatus: Int): Int

    fun findBy(userId: UUID): User?

    fun updatePassword(userId: UUID, newPassword: String): User?
}