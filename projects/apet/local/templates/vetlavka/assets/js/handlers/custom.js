const inputLeft = document.querySelector('.range__input--left')
const inputRight = document.querySelector('.range__input--right')

const thumbLeft = document.querySelector('.range-slider__thumb--left')
const thumbRight = document.querySelector('.range-slider__thumb--right')
const range = document.querySelector('.range-slider__range')

const fieldLeft = document.querySelector('.range-input__field--left')
const fieldRight = document.querySelector('.range-input__field--right')

if (inputLeft) inputLeft.addEventListener('input', setLeftValue)
if (inputRight) inputRight.addEventListener('input', setRightValue)

function setLeftValue() {
  const min = parseInt(inputLeft.min)
  const max = parseInt(inputLeft.max)

  inputLeft.value = Math.min(parseInt(inputLeft.value), parseInt(inputRight.value) - 1)

  const percent = ((inputLeft.value - min) / (max - min)) * 100

  thumbLeft.style.left = percent + '%'
  range.style.left = percent + '%'

  fieldLeft.value = inputLeft.value
}

function setRightValue() {
  const min = parseInt(inputRight.min)
  const max = parseInt(inputRight.max)

  inputRight.value = Math.max(parseInt(inputRight.value), parseInt(inputLeft.value) + 1)

  const percent = ((inputRight.value - min) / (max - min)) * 100

  thumbRight.style.right = (100 - percent) + '%'
  range.style.right = (100 - percent) + '%'

  fieldRight.value = inputRight.value
}
