/* eslint-disable no-undef */
const metrics = {
  init() {
    this.eventHandler()
    return this
  },

  eventHandler() {
    const self = this

    $(document).on('click', '.js-metric-link', function () {
      const goal = $(this).data('goal')
      if (goal)
        self.reachGoal(goal)
    })
  },

  reachGoal(id) {
    if (id) {
      console.info(id)
      this.reachGoalYa(id)
      this.reachGoalGa(id)
    }
  },

  reachGoalYa(id) {
    if (typeof ym !== 'undefined')
      ym(61860661, 'reachGoal', id)
  },

  reachGoalGa(id) {
    if (typeof ga !== 'undefined')
      ga('send', 'event', 'Form', id)
  }
}

export default metrics
