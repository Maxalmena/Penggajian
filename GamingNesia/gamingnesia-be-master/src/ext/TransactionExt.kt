package com.warungsoftware.ext

import com.warungsoftware.domain.model.PaymentMethod
import domain.model.*
import java.util.*

fun ProductRequest.mapToTransactionDetail(transactionId: UUID) : TransactionDetail = TransactionDetail(
    productId = this.productId,
    remarks = this.remarks,
    transactionId = transactionId.toString(),
    quantity = this.quantity
)

fun TransactionRequest.mapToTransaction(paymentId: UUID): Transaction = Transaction(
    uniqueCode = this.uniqueCode,
    totalPrice = this.totalPrice,
    adminFee = this.adminFee,
    paymentId = paymentId.toString(),
    userId = this.buyerId
)

fun TransactionRequest.mapToPayment(): Payment = Payment(
    method = this.paymentMethod,
    paymentConfirmationImage = this.paymentConfirmationImg,
    paymentAmount = this.paymentAmount
)

fun Payment.mapToPaymentWrapper(paymentMethod: PaymentMethod?): PaymentWrapper = PaymentWrapper(
    id = this.id,
    paymentMethod = paymentMethod,
    paymentAmount = this.paymentAmount,
    remarks = this.remarks,
    paymentConfirmationImg = this.paymentConfirmationImage
)

fun Promo.toPromoDto(): PromoDto = PromoDto(
    id = id,
    name = name,
    values = values,
    unit = unit,
    productId = productId,
    description = description,
    status = status
)

fun Product.toPromoDto(promo: Promo?): ProductDto = ProductDto(
    id = this.id,
    categoryId = this.categoryId,
    name = this.name,
    sellingPrice = this.sellingPrice,
    imageUrl = this.imageUrl,
    promo = promo?.toPromoDto(),
    sellerId = this.userId.toString(),
    stock = this.stock,
    sku = this.sku,
    purchasesPrice = this.purchasesPrices,
    status = this.status
)