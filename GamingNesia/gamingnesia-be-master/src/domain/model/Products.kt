package domain.model

import com.google.common.primitives.Floats
import com.google.gson.annotations.SerializedName
import org.jetbrains.exposed.sql.Table

data class ProductDto(
    val id: String?="",
    val name: String,
    val stock: Int ?= 0,
    val sku: String ?= "",
    val imageUrl: String ?= "",
    val purchasesPrice: Float ?= 0.toFloat(),
    val sellingPrice: Float,
    val categoryId: String,
    val sellerId: String,
    val promo: PromoDto?,
    val status: Boolean ?= true
)

data class Product(
    val id: String? = "",
    val name: String,
    val stock: Int,
    val sku: String,
    val imageUrl: String,
    val purchasesPrices: Float,
    val sellingPrice: Float,
    val status: Boolean? = true,
    @SerializedName("sellerId") val userId: String? = "",
    val categoryId: String
)

object Products : Table() {
    val id = uuid("id").primaryKey().autoGenerate()
    val name = varchar("name", 255)
    val stock = integer("stock")
    val sku = varchar("sku", 255)
    val imageUrl = varchar("image_url", 255)
    val purchasesPrice = float("purchases_price")
    val sellingPrice = float("selling_price")
    val categoryId = (uuid("category_id") references Categories.id)
    val status = bool("status")
    val userId = (uuid("user_id") references Users.id)
}