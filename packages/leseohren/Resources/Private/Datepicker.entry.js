// Import vanillajs-datepicker
// See https://mymth.github.io/vanillajs-datepicker/#/
import { Datepicker } from 'vanillajs-datepicker'

const birthday = document.querySelector('input[id="birthday"]')
if (birthday !== null) {
  const datepicker1 = new Datepicker(birthday, {
    format: 'dd.mm.yyyy',
    buttonClass: 'btn',
    autohide: true,
    todayButton: true,
    clearButton: true,
    todayHighlight: true,
  })
}

const statuschangeDate = document.querySelector('input[id="statuschangeDate"]')
if (statuschangeDate !== null) {
  const datepicker2 = new Datepicker(statuschangeDate, {
    format: 'dd.mm.yyyy',
    buttonClass: 'btn',
    autohide: true,
    todayButton: true,
    clearButton: true,
    todayHighlight: true,
  })
}

const statusbeginDate = document.querySelector('input[id="statusbeginDate"]')
if (statusbeginDate !== null) {
  const datepicker3 = new Datepicker(statusbeginDate, {
    format: 'dd.mm.yyyy',
    buttonClass: 'btn',
    autohide: true,
    todayButton: true,
    clearButton: true,
    todayHighlight: true,
  })
}
const statusendDate = document.querySelector('input[id="statusendDate"]')
if (statusendDate !== null) {
  const datepicker4 = new Datepicker(statusendDate, {
    format: 'dd.mm.yyyy',
    buttonClass: 'btn',
    autohide: true,
    todayButton: true,
    clearButton: true,
    todayHighlight: true,
  })
}
const startDate = document.querySelector('input[id="startDate"]')
if (startDate !== null) {
  const datepicker5 = new Datepicker(startDate, {
    format: 'dd.mm.yyyy',
    buttonClass: 'btn',
    autohide: true,
    todayButton: true,
    clearButton: true,
    todayHighlight: true,
  })
}
const endDate = document.querySelector('input[id="endDate"]')
if (endDate !== null) {
  const datepicker6 = new Datepicker(endDate, {
    format: 'dd.mm.yyyy',
    buttonClass: 'btn',
    autohide: true,
    todayButton: true,
    clearButton: true,
    todayHighlight: true,
  })
}

const giftDate = document.querySelector('input[id="giftDate"]')
if (giftDate !== null) {
  const datepicker1 = new Datepicker(giftDate, {
    format: 'dd.mm.yyyy',
    buttonClass: 'btn',
    autohide: true,
    todayButton: true,
    clearButton: true,
    todayHighlight: true,
  })
}
console.log('leseohren Datepicker.entry.js loaded!')
