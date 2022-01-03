const metrics = {
  init() {
    this.eventHandler()
  },

  eventHandler() {
    const self = this

    $(document).on("click", ".js-metric-link", function () {
      const goal = $(this).data("goal")
      if (goal) {
        this.reachGoal(id)
      }
    });
  },

  reachGoal(id) {
    if (id) {
      console.info(id)
      this.reachGoalYa(id)
      this.reachGoalGa(id)
    }
  },

  reachGoalYa(id) {
    if (typeof ya != "undefined") {
      ya("code", "", id)
    }
  },

  reachGoalGa(id) {
    if (typeof ga != "undefined") {
      ga("send", "event", "form", id)
    }
  },

};

export default metrics
