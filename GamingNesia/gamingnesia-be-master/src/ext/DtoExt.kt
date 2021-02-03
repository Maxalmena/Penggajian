package com.warungsoftware.ext

import domain.model.*

fun ProductDto.toProductModel() = Product(
    name = name,
    purchasesPrices = purchasesPrice ?: 0.toFloat(),
    sellingPrice = sellingPrice,
    imageUrl = imageUrl ?: "",
    sku = sku ?: "",
    stock = stock ?: 0,
    userId = sellerId,
    categoryId = categoryId,
    status = status ?: true
)

fun CategoryDto.toCategoryModel() = Category(
    name = name,
    description = description,
    imageCoverUrl = imageCoverUrl,
    imageUrl = imageUrl
)

fun PromoDto.toPromoModel() = Promo(
    name = name ?: "",
    description = description?: "",
    values = values,
    productId = productId,
    unit = unit,
    status = status ?: true
)