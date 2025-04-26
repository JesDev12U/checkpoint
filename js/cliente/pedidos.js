// Tab switching logic
document.querySelectorAll(".tab").forEach((tab) => {
  tab.addEventListener("click", function () {
    document
      .querySelectorAll(".tab")
      .forEach((t) => t.classList.remove("active"));
    document
      .querySelectorAll(".tab-content")
      .forEach((tc) => tc.classList.remove("active"));
    this.classList.add("active");
    document
      .querySelector(".tab-content." + this.dataset.tab)
      .classList.add("active");
  });
});
