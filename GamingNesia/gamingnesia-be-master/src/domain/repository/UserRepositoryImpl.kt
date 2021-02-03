package domain.repository

import com.warungsoftware.domain.repository.UserRepository
import domain.model.User
import domain.model.UserDto
import domain.model.Users
import ext.toUserModel
import org.jetbrains.exposed.sql.insert
import org.jetbrains.exposed.sql.select
import org.jetbrains.exposed.sql.selectAll
import org.jetbrains.exposed.sql.transactions.transaction
import org.jetbrains.exposed.sql.update
import java.util.*

class UserRepositoryImpl : UserRepository {

    override fun findByEmail(email: String): User? {
        return transaction {
            Users.select { Users.email eq email }
                .map {
                    it.toUserModel()
                }
                .firstOrNull()
        }
    }

    override fun create(user: User): UUID? {
        return transaction {
            Users.insert { row ->
                row[email] = user.email
                row[username] = user.username!!
                row[address] = user.address!!
                row[fullName] = user.fullName!!
                row[membership] = user.membership!!
                row[phoneNumber] = user.phoneNumber!!
                row[password] = user.password
                row[profilePic] = user.profilePic!!
            }.getOrNull(Users.id)
        }
    }

    override fun update(userId: UUID, user: UserDto): Int {
        return transaction {
            Users.update({ Users.id eq userId }) {
                it[email] = user.email
                it[address] = user.address!!
                it[fullName] = user.fullName!!
                it[membership] = user.membership!!
                it[phoneNumber] = user.phoneNumber!!
                it[profilePic] = user.profilePic!!
            }
        }
    }

    override fun findBy(username: String): User? {
        return transaction {
            Users.select { Users.username eq username }
                .map {
                    it.toUserModel()
                }
                .firstOrNull()
        }
    }

    override fun getAll(): List<User> {
        return transaction {
            Users.selectAll().map { it.toUserModel() }
        }
    }

    override fun updateMembership(userId: UUID, membershipStatus: Int): Int {
        return transaction {
            Users.update ({Users.id eq userId}) {
                it[membership] = membershipStatus
            }
        }
    }

    override fun findBy(userId: UUID): User? {
        return transaction {
            Users.select { Users.id eq userId }
                .map {
                    it.toUserModel()
                }
                .firstOrNull()
        }
    }

    override fun updatePassword(userId: UUID, newPassword: String): User? {
        return transaction {
            Users.update ({Users.id eq userId}) {
                it[password] = newPassword
            }

            findBy(userId)
        }
    }
}