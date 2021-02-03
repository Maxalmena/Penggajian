package domain.model

import org.jetbrains.exposed.sql.Table

data class PromoDto(
    val id: String?= "",
    val name: String?= "",
    val description: String ?= "",
    val productId: String ? = "",
    val values: Float,
    val unit: Int, //percentage or nominal
    val status: Boolean ?= true
)

data class Promo(
    val id: String? = "",
    val name: String,
    val description: String,
    val productId: String?,
    val values: Float,
    val unit: Int, //percentage or nominal
    val status: Boolean? = true
)

object Promos: Table() {
    val id = uuid("id").primaryKey().autoGenerate()
    val name = varchar("name", 80)
    val description = text("description")
    val productId = (uuid("product_id") references Products.id)
    val values = float("values")
    val unit = integer("unit")
    val status = bool("status").default(true)
}