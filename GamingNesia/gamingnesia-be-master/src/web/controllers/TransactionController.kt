package com.warungsoftware.web.controllers

import com.warungsoftware.domain.exceptions.InvalidRequestException
import com.warungsoftware.domain.exceptions.NotFoundException
import com.warungsoftware.domain.service.TransactionService
import com.warungsoftware.ext.toUUID
import com.warungsoftware.utils.Response
import domain.model.TransactionRequest
import io.ktor.application.ApplicationCall
import io.ktor.http.HttpStatusCode
import io.ktor.request.receive
import io.ktor.response.respond

class TransactionController (private val transactionService: TransactionService) {

    suspend fun create(ctx: ApplicationCall) {
        ctx.receive<TransactionRequest>().apply {
            transactionService.create(this).apply {
                ctx.respond(HttpStatusCode.Created, Response("success", payload = this))
            }
        }
    }

    suspend fun findAll(ctx: ApplicationCall) {
        val buyerId = ctx.parameters["buyerId"] ?: ""
        val sellerId = ctx.parameters["sellerId"] ?: ""

        if (buyerId.isEmpty() && sellerId.isEmpty()) {
            transactionService.findAll().apply {
                ctx.respond(HttpStatusCode.OK, Response("success", payload = this))
            }
        } else if(buyerId.isNotEmpty() && sellerId.isEmpty()) {
            transactionService.findByBuyer(buyerId).apply {
                ctx.respond(HttpStatusCode.OK, Response("success", payload = this))
            }
        } else if (sellerId.isNotEmpty() && buyerId.isEmpty()) {
            transactionService.findBySeller(sellerId).apply {
                ctx.respond(HttpStatusCode.OK, Response("success", payload = this))
            }
        } else {
            ctx.respond(HttpStatusCode.BadRequest, Response("error", error = "Invalid Request"))
        }
    }

    data class UpdateTransactionRequest(val status: Int)

    suspend fun findById(ctx: ApplicationCall) {
        try {
            transactionService.findById(ctx.parameters["id"]!!.toUUID()).apply {
                ctx.respond(HttpStatusCode.OK, Response("success", payload = this))
            }
        } catch (e: InvalidRequestException) {
            ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
        } catch (e: NotFoundException) {
            ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
        }

    }

    suspend fun update(ctx: ApplicationCall) {
        ctx.receive<UpdateTransactionRequest>().apply{
            try {
                transactionService.update(ctx.parameters["id"]!!.toUUID(), this.status).apply {
                    ctx.respond(HttpStatusCode.OK, Response("success", payload = this))
                }
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            }
        }
    }


}