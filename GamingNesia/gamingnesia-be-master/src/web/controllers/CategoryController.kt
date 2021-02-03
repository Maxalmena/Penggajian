package com.warungsoftware.web.controllers

import com.warungsoftware.domain.exceptions.InvalidRequestException
import com.warungsoftware.domain.exceptions.NotFoundException
import com.warungsoftware.domain.service.CategoryService
import com.warungsoftware.utils.Response
import domain.model.CategoryDto
import io.ktor.application.ApplicationCall
import io.ktor.http.HttpStatusCode
import io.ktor.request.receive
import io.ktor.response.respond

class CategoryController (private val categoryService: CategoryService) {

    suspend fun create(ctx: ApplicationCall) {
        ctx.receive<CategoryDto>().apply {
            categoryService.create(this).apply {
                ctx.respond(HttpStatusCode.Created, this)
            }
        }
    }

    suspend fun getAll(ctx: ApplicationCall) {
        val nameParam = ctx.parameters["name"] ?: ""

        if (nameParam.isNotEmpty()) {
            try {
                categoryService.getBy(nameParam).apply {
                    ctx.respond(HttpStatusCode.OK, Response("success", this))
                }
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            }
            return
        }

        categoryService.getAll().apply {
            ctx.respond(HttpStatusCode.OK, Response("success", this))
        }
    }

    suspend fun getById(ctx: ApplicationCall) {
        ctx.parameters["id"].let {
            try {
                categoryService.getById(it ?: "").apply {
                    ctx.respond(HttpStatusCode.OK, Response("success", this))
                }
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            }

        }
    }

    suspend fun getByName(ctx: ApplicationCall) {
        ctx.parameters["name"].let {
            try {
                categoryService.getBy(it ?: "").apply {
                    ctx.respond(HttpStatusCode.OK, Response("success", this))
                }
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            }

        }
    }

    suspend fun delete(ctx: ApplicationCall) {
        ctx.parameters["id"].let {
            try {
                categoryService.delete(it ?: "").apply {
                    ctx.respond(HttpStatusCode.NoContent)
                }
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            }
        }
    }

    suspend fun update(ctx: ApplicationCall) {
        val id = ctx.parameters["id"]
        ctx.receive<CategoryDto>().apply {
            try {
                categoryService.update(id ?: "", this).apply {
                    ctx.respond(HttpStatusCode.OK, Response("success", this))
                }
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            }
        }
    }

}