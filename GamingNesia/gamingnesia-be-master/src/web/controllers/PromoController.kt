package com.warungsoftware.web.controllers

import com.warungsoftware.domain.exceptions.InvalidRequestException
import com.warungsoftware.domain.exceptions.NotFoundException
import com.warungsoftware.domain.service.PromoService
import com.warungsoftware.utils.Response
import domain.model.PromoDto
import io.ktor.application.ApplicationCall
import io.ktor.http.HttpStatusCode
import io.ktor.request.receive
import io.ktor.response.respond

class PromoController (private val promoService: PromoService) {

    suspend fun configPromo(ctx: ApplicationCall) {
        ctx.receive<PromoDto>().apply {
            promoService.configPromo(this).apply {
                ctx.respond(HttpStatusCode.Created, Response("success",this))
            }
        }
    }

    suspend fun getAll(ctx: ApplicationCall) {
        promoService.getAll().apply {
            ctx.respond(HttpStatusCode.OK, Response("success", this))
        }
    }

    suspend fun getById(ctx: ApplicationCall) {
        ctx.parameters["id"].let {
            try {
                promoService.getById(it ?: "").apply {
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
                promoService.delete(it ?: "").apply {
                    ctx.respond(HttpStatusCode.NoContent)
                }
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            }
        }
    }

}