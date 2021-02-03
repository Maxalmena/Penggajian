package com.warungsoftware.web.controllers

import com.warungsoftware.domain.model.Helper
import com.warungsoftware.domain.service.HelperService
import com.warungsoftware.utils.Response
import io.ktor.application.ApplicationCall
import io.ktor.http.HttpStatusCode
import io.ktor.request.receive
import io.ktor.response.respond

class HelperController (private val helperService: HelperService) {

    suspend fun create(ctx: ApplicationCall) {
        ctx.receive<Helper>().apply {
            helperService.create(this).apply {
                ctx.respond(HttpStatusCode.Created, Response("success", this))
            }
        }
    }

    suspend fun getAll(ctx: ApplicationCall) {
        val type = ctx.parameters["type"] ?: ""
        if (type.isNotEmpty()){
            helperService.findByType(type).apply {
                ctx.respond(HttpStatusCode.OK, Response("success", this))
            }
        }else {
            helperService.findAll().apply {
                ctx.respond(HttpStatusCode.OK, Response("success", this))
            }
        }
    }

    suspend fun update(ctx: ApplicationCall) {
        val type = ctx.parameters["type"] ?: ""

        if (type.isNotEmpty()) {
            ctx.receive<Helper>().apply {
                helperService.update(type, this).apply {
                    ctx.respond(HttpStatusCode.OK, Response("success", this))
                }
            }
        } else {
            ctx.respond(HttpStatusCode.BadRequest, Response("error", error = "Type not found"))
        }
    }

}