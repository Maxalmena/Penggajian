package com.warungsoftware.web.controllers

import com.warungsoftware.domain.exceptions.InvalidRequestException
import com.warungsoftware.domain.exceptions.NotFoundException
import com.warungsoftware.domain.exceptions.AuthorizationException
import com.warungsoftware.domain.service.UserService
import com.warungsoftware.ext.toUUID
import com.warungsoftware.utils.JwtProvider
import com.warungsoftware.utils.Response
import domain.model.*
import io.ktor.application.ApplicationCall
import io.ktor.http.HttpStatusCode
import io.ktor.request.header
import io.ktor.request.receive
import io.ktor.response.respond
import java.util.*

class UserController(private val userService: UserService, private val jwtProvider: JwtProvider) {

    suspend fun register(ctx: ApplicationCall) {
        ctx.receive<RegisterDto>().apply {
            try {
                userService.create(this).apply {
                    ctx.respond(HttpStatusCode.Created, Response("success", Auth(this as String)))
                }
            } catch (e: AuthorizationException) {
                ctx.respond(HttpStatusCode.Conflict, Response("error", error = e.localizedMessage))
            }
        }
    }

    suspend fun login(ctx: ApplicationCall) {
        ctx.receive<LoginDto>().apply {
            try {
                userService.login(this.validLogin()).apply {
                    ctx.respond(HttpStatusCode.Created, Response("success", Auth(this as String)))
                }
            } catch (e: AuthorizationException) {
                ctx.respond(HttpStatusCode.Conflict, Response("error", error = e.localizedMessage))
            }
        }
    }

    suspend fun getAll(ctx: ApplicationCall) {
        userService.getAll().apply {
            ctx.respond(HttpStatusCode.OK, Response("success", this))
        }
    }

    suspend fun getByUsername(ctx: ApplicationCall) {
        ctx.parameters["username"].let {
            try {
                userService.findBy(username = it ?: "").apply {
                    ctx.respond(HttpStatusCode.OK, Response("Success", this))
                }
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            }
        }
    }

    suspend fun update(ctx: ApplicationCall) {
        ctx.parameters["id"].let {
            ctx.receive<UserDto>().apply {
                try {
                    userService.update(userId = it ?: "", user = this).apply {
                        ctx.respond(HttpStatusCode.NoContent, Response("Success", payload = ""))
                    }
                } catch (e: NotFoundException) {
                    ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
                }
            }
        }
    }

    suspend fun updateMembership(ctx: ApplicationCall) {
        ctx.parameters["id"]?.let { id ->
            ctx.receive<UserDto>().apply {
                try {
                    this.membership?.let { membership ->
                        userService.updateMembership(id, membership)
                    }.apply {
                        ctx.respond(HttpStatusCode.OK, Response("success", this))
                    }
                } catch (e: NotFoundException) {
                    ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
                } catch (e: InvalidRequestException) {
                    ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
                }
            }
        }

    }

    fun getByEmail(email: String?): User? {
        return email.let {
            require(!it.isNullOrBlank()) { "User not logged or with invalid email." }
            userService.findByEmail(it)
        }
    }

    suspend fun getById(ctx: ApplicationCall) {
        ctx.parameters["id"]?.let {
            try {
                userService.findBy(userId = it.toUUID()).apply {
                    ctx.respond(HttpStatusCode.OK, Response("Success", this))
                }
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            }
        }
    }

    suspend fun changePassword(ctx: ApplicationCall) {
        val id = ctx.parameters["id"] ?: ""

        try {
            ctx.receive<ChangePasswordDto>().apply {
                userService.changePassword(userId = id, changePasswordDto = this).apply {
                    ctx.respond(HttpStatusCode.OK, Response("Success", this))
                }
            }
        } catch (e: NotFoundException) {
            ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
        } catch (e: InvalidRequestException) {
            ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
        } catch (e: AuthorizationException) {
            ctx.respond(HttpStatusCode.Conflict, Response("error", error = e.localizedMessage))
        }
    }


    suspend fun me(ctx: ApplicationCall) {
        val bearer = ctx.request.header("Authorization")

        val token = bearer?.substring(7)

        val jwt = jwtProvider.decodeJWT(token?:"")
        val email = jwt.claims["email"]?.asString()

        try {
            userService.findByEmail(email ?: "").apply {
                ctx.respond(HttpStatusCode.OK, Response("Success", this))
            }
        } catch (e: NotFoundException) {
            ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
        } catch (e: InvalidRequestException) {
            ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
        }

    }

}
