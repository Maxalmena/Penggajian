package domain.model

import com.google.gson.annotations.SerializedName
import com.warungsoftware.config.Exclude
import com.warungsoftware.domain.model.PaymentMethod
import org.jetbrains.exposed.sql.Table
import org.joda.time.DateTime

data class Transaction(
    val id: String? = "",
    @SerializedName("buyerId") val userId: String,
    val date: String = DateTime.now().toDateTimeISO().toString(),
    val paymentId: String,
    val totalPrice: Float,
    val status: Int = 0,
    val adminFee: Float,
    val uniqueCode: Int
)

data class TransactionWrapper(
    val id: String?,
    val date: String?,
    val uniqueCode: Int?,
    val adminFee: Float?,
    val totalPrice: Float?,
    val buyerId: String?,
    val transactionDetails: List<TransactionDetailWrapper>,
    val payment: PaymentWrapper?,
    val status: Int?
)

data class TransactionDetailWrapper(
    val id: String? = "",
    val product: ProductWrapper,
    val quantity: Int,
    val remarks: String,
    @Exclude val transactionId: String
)

data class ProductWrapper(
    val id: String? = "",
    val name: String,
    val imageUrl: String,
    val sellingPrice: Float,
    val sellerId: String? = "",
    val categoryId: String,
    val promo: PromoWrapper
)

data class PromoWrapper(
    val id: String?="",
    val unit: Int,
    val status: Boolean,
    val value: Float
)

data class PaymentWrapper(
    val id: String?,
    val paymentMethod: PaymentMethod?,
    val remarks: String?,
    val paymentConfirmationImg: String?,
    val paymentAmount: Float?
)

data class ProductRequest(
    val productId: String,
    val quantity: Int,
    val remarks: String
)

data class TransactionRequest(
    val products: List<ProductRequest>,
    val paymentConfirmationImg: String,
    val paymentMethod: String,
    val uniqueCode: Int,
    val buyerId: String,
    val totalPrice: Float,
    val adminFee: Float,
    val paymentAmount: Float
)

object Transactions: Table() {
    val id = uuid("id").primaryKey().autoGenerate()
    val userId = (uuid("user_id") references Users.id)
    val date = datetime("date")
    val paymentId = (uuid("payment_id") references Payments.id)
    val totalPrice = float("total_price")
    val status = integer("status")
    val adminFee = float("admin_fee")
    val uniqueCode = integer("unique_code")
}