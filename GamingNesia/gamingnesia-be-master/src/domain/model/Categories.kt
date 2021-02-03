package domain.model

import org.jetbrains.exposed.sql.Table

data class CategoryDto(
    val name: String,
    val description: String,
    val imageUrl: String,
    val imageCoverUrl: String
)

data class Category(
    val id: String? = "",
    val name: String,
    val description: String? = "",
    val imageUrl: String? = "",
    val imageCoverUrl: String? = "",
    val status: Boolean? = true
)

object Categories: Table() {
    val id = uuid("id").primaryKey().autoGenerate()
    val name = varchar("name", 40)
    val description = text("description")
    val imageUrl = varchar("image_url", 255)
    val imageCoverUrl = varchar("image_cover_url", 255)
    val status = bool("status").default(true)
}