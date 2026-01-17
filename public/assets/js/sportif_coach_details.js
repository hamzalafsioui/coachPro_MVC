document.addEventListener("DOMContentLoaded", function () {
  const tabs = document.querySelectorAll(".tab-btn");
  const sections = document.querySelectorAll(".content-section");
  const timeSlots = document.querySelectorAll(".time-slot");
  const bookBtn = document.getElementById("bookSessionBtn");
  const selectedAvailabilityInput = document.getElementById(
    "selected_availability_id"
  );

  // Tab Switching
  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      const target = tab.getAttribute("data-target");

      // Update tabs
      tabs.forEach((t) => t.classList.remove("active", "text-white"));
      tabs.forEach((t) => t.classList.add("text-gray-400"));
      tab.classList.remove("text-gray-400");
      tab.classList.add("active", "text-white");

      // Update sections
      sections.forEach((s) => s.classList.add("hidden"));
      document.getElementById(target).classList.remove("hidden");
    });
  });

  // Time Slot Selection logic
  timeSlots.forEach((slot) => {
    slot.addEventListener("click", () => {
      // Deselect others
      timeSlots.forEach((s) => {
        s.classList.remove("bg-blue-600", "text-white", "border-blue-500");
        s.classList.add("bg-gray-800/50", "text-gray-300", "border-gray-700");
      });

      // Select clicked
      slot.classList.remove(
        "bg-gray-800/50",
        "text-gray-300",
        "border-gray-700"
      );
      slot.classList.add("bg-blue-600", "text-white", "border-blue-500");

      const selectedSlotTime = slot.getAttribute("data-time");
      const selectedSlotId = slot.getAttribute("data-id");

      if (selectedAvailabilityInput) {
        selectedAvailabilityInput.value = selectedSlotId;
      }

      // Enable book button
      if (bookBtn) {
        bookBtn.disabled = false;
        bookBtn.classList.remove("opacity-50", "cursor-not-allowed");
        bookBtn.textContent = `Book for ${selectedSlotTime}`;
      }
    });
  });
});

function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebarOverlay");

  if (sidebar.classList.contains("-translate-x-full")) {
    sidebar.classList.remove("-translate-x-full");
    overlay.classList.remove("hidden");
  } else {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("hidden");
  }
}
