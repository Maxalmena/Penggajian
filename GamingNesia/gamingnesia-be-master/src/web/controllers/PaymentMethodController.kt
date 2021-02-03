package com.warungsoftware.web.controllers

import com.warungsoftware.domain.exceptions.InvalidRequestException
import com.warungsoftware.domain.exceptions.NotFoundException
import com.warungsoftware.domain.model.PaymentMethod
import com.warungsoftware.domain.service.PaymentMethodsService
import com.warungsoftware.utils.Response
import io.ktor.application.ApplicationCall
import io.ktor.http.HttpStatusCode
import io.ktor.request.receive
import io.ktor.response.respond

class PaymentMethodController (private val paymentMethodsService: PaymentMethodsService) {

    suspend fun create(ctx: ApplicationCall) {
        ctx.receive<PaymentMethod>().apply {
            paymentMethodsService.create(this).apply {
                ctx.respond(HttpStatusCode.OK, Response("success", this))
            }
        }
    }

    suspend fun getAll(ctx: ApplicationCall) {
        paymentMethodsService.getAll().apply {
            ctx.respond(HttpStatusCode.OK, Response("success", this))
        }
    }

    suspend fun delete(ctx: ApplicationCall) {
        ctx.parameters["id"].let {
            try {
                paymentMethodsService.delete(it ?: "").apply {
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