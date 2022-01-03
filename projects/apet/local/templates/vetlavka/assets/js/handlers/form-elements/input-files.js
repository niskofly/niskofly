class InputFiles {
  constructor($wrapper) {
    this.$wrapper = $wrapper;
    this.$input = $wrapper.find('[type="file"]');
    this.$countArea = $wrapper.find(".js-input-files-count-area");
    this.$form = $wrapper.closest("form");
    this.defaultName = this.$countArea.text();
    this.eventHandler();
  }

  eventHandler() {
    this.$input.on("input", () => {
      this.updateFileName();
    });

    this.$form.on("reset", () => {
      this.updateFileName(0);
    });
  }

  updateFileName(fileCount) {
    fileCount =
      typeof fileCount != "undefined"
        ? fileCount
        : this.$input[0].files.length;

    if (fileCount > 0)
      return this.$countArea.text(`Выбрано файлов (${fileCount})`);

    this.$countArea.text(this.defaultName);
  }
}

export default InputFiles;
