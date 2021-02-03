package com.warungsoftware.utils

data class Response<out T> constructor(
    val status: String,
    val payload: T? = null,
    val error: T? = null
)