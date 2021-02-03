package com.warungsoftware.web.controllers

import com.warungsoftware.domain.exceptions.InvalidRequestException
import com.warungsoftware.domain.exceptions.NotFoundException
import com.warungsoftware.domain.service.ProductService
import com.warungsoftware.ext.toProductModel
import com.warungsoftware.utils.Response
import domain.model.Product
import domain.model.ProductDto
import io.ktor.application.ApplicationCall
import io.ktor.http.HttpStatusCode
import io.ktor.request.receive
import io.ktor.response.respond

class ProductController (private val productService: ProductService) {

    suspend fun create(ctx: ApplicationCall) {
        ctx.receive<ProductDto>().apply {
            productService.create(this).apply {
                ctx.respond(HttpStatusCode.Created, Response("success", this))
            }
        }
    }

    suspend fun getAll(ctx: ApplicationCall) {
        val nameParam = ctx.parameters["name"] ?: ""

        val sellerParam = ctx.parameters["sellerId"] ?: ""

        val categoryParam = ctx.parameters["categoryId"] ?: ""

        if (nameParam.isNotEmpty()) {
            try {
                productService.findBy(nameParam).apply {
                    ctx.respond(HttpStatusCode.OK, Response("success", this))
                }
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            }
            return
        }else if (categoryParam.isNotEmpty()) {
            try {
                productService.findByCategory(categoryParam).apply {
                    ctx.respond(HttpStatusCode.OK, Response("success", this))
                }
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            }
            return
        }else if (sellerParam.isNotEmpty()) {
            try {
                productService.findBySeller(sellerParam).apply {
                    ctx.respond(HttpStatusCode.OK, Response("success", this))
                }
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            }
            return
        }

        productService.getAll().apply {
            ctx.respond(HttpStatusCode.OK, Response("success", this))
        }
    }

    suspend fun findByName(ctx: ApplicationCall) {
        ctx.parameters["name"].let {
            try {
                productService.findBy(it ?: "").apply {
                    ctx.respond(HttpStatusCode.OK, Response("success", this))
                }
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            }
        }
    }

    suspend fun getById(ctx: ApplicationCall) {
        ctx.parameters["id"].let {
            try {
                productService.getById(it ?: "").apply {
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
                productService.delete(it ?: "").apply {
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
        ctx.parameters["id"].let {
            try {
                ctx.receive<ProductDto>().apply {
                    productService.updateProduct(it ?: "", this).apply {
                        ctx.respond(HttpStatusCode.OK, Response("success", this))
                    }
                }
            } catch (e: InvalidRequestException) {
                ctx.respond(HttpStatusCode.BadRequest, Response("error", error = e.localizedMessage))
            } catch (e: NotFoundException) {
                ctx.respond(HttpStatusCode.NotFound, Response("error", error = e.localizedMessage))
            }
        }
    }

}