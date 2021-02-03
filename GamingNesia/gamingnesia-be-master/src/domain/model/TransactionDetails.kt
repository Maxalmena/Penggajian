package domain.model

import org.jetbrains.exposed.sql.Table

data class TransactionDetail(
    val id: String? = "",
    val transactionId: String,
    val productId: String,
    val quantity: Int,
    val remarks: String
)

object TransactionDetails: Table() {
    val id = uuid("id").primaryKey().autoGenerate()
    val transactionId = (uuid("transaction_id") references Transactions.id)
    val productId = (uuid("product_id") references Products.id)
    val quantity = integer("quantity")
    val remarks = varchar("remarks", 100)
}