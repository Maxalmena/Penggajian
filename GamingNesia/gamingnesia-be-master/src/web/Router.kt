package com.warungsoftware.web

import com.warungsoftware.web.controllers.*
import io.ktor.auth.authenticate
import io.ktor.routing.*
import org.koin.ktor.ext.get
import org.koin.ktor.ext.inject

fun Routing.products(productController: ProductController) {

    route("products") {
        get("/{id}") { productController.getById(this.context) }
        get("") { productController.getAll(this.context) }
        authenticate {
            post { productController.create(this.context) }

            delete("/{id}") { productController.delete(this.context) }
            put("/{id}") {productController.update(this.context)}
        }
    }
}

fun Routing.users(userController: UserController) {
    post("/login") { userController.login(this.context) }

    get("/me") { userController.me(this.context) }

    route("users") {
        post { userController.register(this.context) }

        authenticate {

            put("/{id}") { userController.update(this.context) }
            put("/{id}/membership") { userController.updateMembership(this.context) }
            put("/{id}/changePassword") { userController.changePassword(this.context) }

            get("") { userController.getAll(this.context) }
            get("/{id}") { userController.getById(this.context) }
        }

    }
}

fun Routing.category(categoryController: CategoryController) {

    route("categories") {
        get("/") { categoryController.getAll(this.context) }
        get("/{id}") { categoryController.getById(this.context) }
        authenticate {
            post { categoryController.create(this.context) }
            delete("/{id}") { categoryController.delete(this.context) }
            put("/{id}") {categoryController.update(this.context)}
        }
    }
}

fun Routing.promo(promoController: PromoController) {
    authenticate {
        route("promos") {
            post { promoController.configPromo(this.context) }
            get("") { promoController.getAll(this.context) }
            get("/{id}") { promoController.getById(this.context) }
            delete("/{id}") { promoController.delete(this.context) }
        }
    }
}

fun Routing.transaction(transactionController: TransactionController) {
    authenticate {
        route("transactions") {
            post { transactionController.create(this.context) }

            get("/") { transactionController.findAll(this.context) }
            get("/{id}") {transactionController.findById(this.context)}

            patch("/{id}/status") {transactionController.update(this.context)}

        }
    }

}

fun Routing.helper(helperController: HelperController) {

    route("helpers") {
        get("/") { helperController.getAll(this.context) }
        authenticate {
        post { helperController.create(this.context) }


        put("/") { helperController.update(this.context) }
        }
    }

}

fun Routing.paymentMethods(paymentMethodController: PaymentMethodController) {
    route("paymentMethods") {
        get("/") { paymentMethodController.getAll(this.context) }
        authenticate {
            post { paymentMethodController.create(this.context) }
            delete("/{id}") { paymentMethodController.delete(this.context) }
        }
    }
}