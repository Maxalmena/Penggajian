package com.warungsoftware.config

import com.warungsoftware.domain.repository.*
import com.warungsoftware.domain.service.*
import com.warungsoftware.ext.BcryptHasher
import com.warungsoftware.utils.JwtProvider
import com.warungsoftware.web.controllers.*
import domain.repository.UserRepositoryImpl
import org.koin.dsl.module
import org.koin.experimental.builder.single
import org.koin.experimental.builder.singleBy

val userModule = module(createdAtStart = true) {
    singleBy<UserRepository, UserRepositoryImpl>()
    single<UserService>()
    single<UserController>()
}

val productModule = module(createdAtStart = true) {
    singleBy<ProductRepository, ProductRepositoryImpl>()
    single<ProductService>()
    single<ProductController>()
}

val categoryModule = module(createdAtStart = true) {
    singleBy<CategoryRepository, CategoryRepositoryImpl>()
    single<CategoryService>()
    single<CategoryController>()
}

val promoModule = module(createdAtStart = true) {
    singleBy<PromoRepository, PromoRepositoryImpl>()
    single<PromoService>()
    single<PromoController>()
}

val transactionModule = module(createdAtStart = true) {
    singleBy<TransactionRepository, TransactionRepositoryImpl>()
    single<TransactionService>()
    single<TransactionController>()
}

val transactionDetailModule = module(createdAtStart = true) {
    singleBy<TransactionDetailRepository, TransactionDetailRepositoryImpl>()
}

val paymentModule = module(createdAtStart = true) {
    singleBy<PaymentRepository, PaymentRepositoryImpl>()
}

val paymentMethodModule = module(createdAtStart = true) {
    singleBy<PaymentMethodRepository, PaymentMethodRepositoryImpl>()
    single<PaymentMethodsService>()
    single<PaymentMethodController>()
}

val helperModule = module(createdAtStart = true) {
    singleBy<HelperRepository, HelperRepositoryImpl>()
    single<HelperService>()
    single<HelperController>()
}

val utilModule = module(createdAtStart = true) {
    single<JwtProvider>()
    single<BcryptHasher>()
}