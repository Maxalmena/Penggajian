export const inputPriceFormat = (input) => {
  if(input.length > 3) {
    const price = input.split('.').join('')
    input = price.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
  }

  return input
}