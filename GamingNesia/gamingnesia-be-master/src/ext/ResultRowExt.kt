package ext

import com.warungsoftware.domain.model.Helper
import com.warungsoftware.domain.model.Helpers
import com.warungsoftware.domain.model.PaymentMethod
import com.warungsoftware.domain.model.PaymentMethods
import com.warungsoftware.ext.mapToPaymentWrapper
import domain.model.*
import org.jetbrains.exposed.sql.ResultRow

fun ResultRow.toProductModel(): Product = Product(
    id = this[Products.id].toString(),
    name = this[Products.name],
    stock = this[Products.stock],
    sku = this[Products.sku],
    imageUrl = this[Products.imageUrl],
    sellingPrice = this[Products.sellingPrice],
    purchasesPrices = this[Products.purchasesPrice],
    status = this[Products.status],
    userId = this[Products.userId].toString(),
    categoryId = this[Products.categoryId].toString()
)

fun ResultRow.toUserModel(): User = User(
    id = this[Users.id].toString(),
    fullName = this[Users.fullName],
    username = this[Users.username],
    address = this[Users.address],
    email = this[Users.email],
    membership = this[Users.membership],
    password = this[Users.password],
    phoneNumber = this[Users.phoneNumber],
    profilePic = this[Users.profilePic]
)

fun ResultRow.toCategoryModel(): Category = Category(
    id = this[Categories.id].toString(),
    name = this[Categories.name],
    status = this[Categories.status],
    imageUrl = this[Categories.imageUrl],
    imageCoverUrl = this[Categories.imageCoverUrl],
    description = this[Categories.description]
)

fun ResultRow.toPromoModel(): Promo = Promo(
    id = this[Promos.id].toString(),
    name = this[Promos.name],
    description = this[Promos.description],
    unit = this[Promos.unit],
    productId = this[Promos.productId].toString(),
    values = this[Promos.values],
    status = this[Promos.status]
)

fun ResultRow.toTransactionModel(): Transaction = Transaction(
    id = this[Transactions.id].toString(),
    userId = this[Transactions.userId].toString(),
    paymentId = this[Transactions.paymentId].toString(),
    status = this[Transactions.status],
    adminFee = this[Transactions.adminFee],
    date = this[Transactions.date].toString(),
    totalPrice = this[Transactions.totalPrice],
    uniqueCode = this[Transactions.uniqueCode]
)

fun ResultRow.toTransactionDetailModel(): TransactionDetail = TransactionDetail(
    id = this[TransactionDetails.id].toString(),
    productId = this[TransactionDetails.productId].toString(),
    quantity = this[TransactionDetails.quantity],
    remarks = this[TransactionDetails.remarks],
    transactionId = this[TransactionDetails.transactionId].toString()
)

fun ResultRow.toPaymentModel(): Payment = Payment(
    id = this[Payments.id].toString(),
    remarks = this[Payments.remarks],
    method = this[Payments.method].toString(),
    paymentAmount = this[Payments.paymentAmount],
    paymentConfirmationImage = this[Payments.paymentConfirmationPic]
)

fun ResultRow.toPaymentMethodModel(): PaymentMethod = PaymentMethod(
    id = this[PaymentMethods.id].toString(),
    name = this[PaymentMethods.name],
    accountName = this[PaymentMethods.accountName],
    accountNumber = this[PaymentMethods.accountNumber]
)

fun ResultRow.toTransactionWrapper(transactionDetails: List<TransactionDetailWrapper>): TransactionWrapper = TransactionWrapper(
    id = this[Transactions.id].toString(),
    transactionDetails = transactionDetails,
    payment = this.toPaymentModel().mapToPaymentWrapper(this.toPaymentMethodModel()),
    buyerId = this[Transactions.userId].toString(),
    date = this[Transactions.date].toString(),
    uniqueCode = this[Transactions.uniqueCode],
    totalPrice = this[Transactions.totalPrice],
    adminFee = this[Transactions.adminFee],
    status = this[Transactions.status]
)

fun ResultRow.toProductWrapper(): ProductWrapper = ProductWrapper(
    id = this[Products.id].toString(),
    sellerId = this[Products.userId].toString(),
    name = this[Products.name],
    imageUrl = this[Products.imageUrl],
    sellingPrice = this[Products.sellingPrice],
    categoryId = this[Products.categoryId].toString(),
    promo = this.toPromoWrapper()
)

fun ResultRow.toTransactionDetailWrapper(): TransactionDetailWrapper = TransactionDetailWrapper(
    id = this[TransactionDetails.id].toString(),
    product = this.toProductWrapper(),
    remarks = this[TransactionDetails.remarks],
    quantity = this[TransactionDetails.quantity],
    transactionId = this[TransactionDetails.transactionId].toString()
)

fun ResultRow.toPromoWrapper(): PromoWrapper = PromoWrapper(
    id = this[Promos.id].toString(),
    value = this[Promos.values],
    status = this[Promos.status],
    unit = this[Promos.unit]
)

fun ResultRow.toHelperModel(): Helper = Helper(
    id = this[Helpers.id],
    type = this[Helpers.type],
    value = this[Helpers.value]
)