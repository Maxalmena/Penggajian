package com.warungsoftware

import com.warungsoftware.config.*
import com.warungsoftware.utils.JwtProvider
import com.warungsoftware.web.*
import com.warungsoftware.web.controllers.*
import io.ktor.application.*
import io.ktor.routing.*
import io.ktor.auth.*
import io.ktor.auth.jwt.jwt
import io.ktor.gson.*
import io.ktor.features.*
import io.ktor.http.HttpHeaders
import io.ktor.http.HttpMethod
import org.koin.ktor.ext.Koin
import org.koin.Logger.slf4jLogger
import org.koin.ktor.ext.inject
import web.setup
import java.time.Duration

fun main(args: Array<String>): Unit = io.ktor.server.netty.EngineMain.main(args)

@Suppress("unused") // Referenced in application.conf
@kotlin.jvm.JvmOverloads
fun Application.module(testing: Boolean = false) {

    install(CORS) {
        method(HttpMethod.Delete)
        method(HttpMethod.Patch)
        method(HttpMethod.Put)
        method(HttpMethod.Post)
        method(HttpMethod.Get)
        method(HttpMethod.Options)

        header(HttpHeaders.XForwardedProto)
        header(HttpHeaders.Authorization)
        header(HttpHeaders.AccessControlRequestMethod)
        header(HttpHeaders.AccessControlAllowHeaders)
        header(HttpHeaders.AccessControlAllowMethods)
        header(HttpHeaders.AccessControlAllowOrigin)
        header(HttpHeaders.AccessControlRequestHeaders)

        anyHost()
        allowCredentials = true
        allowNonSimpleContentTypes = true

        maxAge = Duration.ofMinutes(10)
    }

    install(Koin) {
        slf4jLogger()
        modules(listOf(userModule, productModule, categoryModule, promoModule, transactionModule, transactionDetailModule, paymentModule, paymentMethodModule, helperModule, utilModule))
    }

    val categoryController by inject<CategoryController>()
    val productController by inject<ProductController>()
    val userController by inject<UserController>()
    val promoController by inject<PromoController>()
    val transactionController by inject<TransactionController>()
    val helperController by inject<HelperController>()
    val jwtProvider by inject<JwtProvider>()
    val paymentMethodController by inject<PaymentMethodController>()

    install(Authentication) {
        jwt {
            verifier(jwtProvider.verifier)
            authSchemes()
            validate { credential ->
                if (credential.payload.audience.contains(JwtProvider.audience)) {
                    userController.getByEmail(credential.payload.claims["email"]?.asString())
                } else null
            }
        }
    }

    install(ContentNegotiation) {
        gson {
            this.setExclusionStrategies(AnnotationExclusionStrategy())
                .setPrettyPrinting()
        }
    }

    install(StatusPages) {
        setup()
    }

    install(CallLogging)

    DbConfig.setup("", "")
    DbConfig.createTable()

    install(Routing) {
        users(userController)
        products(productController)
        category(categoryController)
        promo(promoController)
        transaction(transactionController)
        helper(helperController)
        paymentMethods(paymentMethodController)
    }
}

