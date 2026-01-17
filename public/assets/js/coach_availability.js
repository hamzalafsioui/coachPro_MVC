document.addEventListener("DOMContentLoaded", function () {
  console.log("Coach Availability JS loaded");
  if (typeof BASE_URL === "undefined") {
    console.error("BASE_URL not defined in window");
  } else {
    console.log("BASE_URL:", BASE_URL);
  }

  const days = [
    "monday",
    "tuesday",
    "wednesday",
    "thursday",
    "friday",
    "saturday",
    "sunday",
  ];

  days.forEach((day) => {
    try {
      const toggle = document.getElementById(`${day}-toggle`);
      const slotsContainer = document.getElementById(`${day}-slots`);
      const addBtn = document.getElementById(`${day}-add-btn`);

      if (toggle && slotsContainer && addBtn) {
        toggle.addEventListener("change", function () {
          if (this.checked) {
            slotsContainer.classList.remove(
              "opacity-50",
              "pointer-events-none"
            );
            addBtn.disabled = false;
            addBtn.classList.remove("opacity-50", "cursor-not-allowed");
          } else {
            slotsContainer.classList.add("opacity-50", "pointer-events-none");
            addBtn.disabled = true;
            addBtn.classList.add("opacity-50", "cursor-not-allowed");
          }
        });

        addBtn.addEventListener("click", function () {
          console.log("Add interval clicked for " + day);
          addTimeSlot(day);
        });
      } else {
        console.warn(
          `Elements for ${day} not found: toggle=${!!toggle}, slots=${!!slotsContainer}, addBtn=${!!addBtn}`
        );
      }
    } catch (err) {
      console.error(`Error initializing ${day}:`, err);
    }
  });
});

function addTimeSlot(day) {
  const container = document.getElementById(`${day}-slots-container`);
  if (!container) {
    console.error(`Container not found for ${day}`);
    return;
  }
  const newSlot = document.createElement("div");
  newSlot.className = "flex items-center gap-2 mb-2 time-slot animate-fade-in";
  newSlot.innerHTML = `
        <input type="time" name="${day}_start[]" class="time-input bg-gray-800 border-gray-700 rounded-lg px-3 py-2 text-sm text-white w-32">
        <span class="text-gray-500">-</span>
        <input type="time" name="${day}_end[]" class="time-input bg-gray-800 border-gray-700 rounded-lg px-3 py-2 text-sm text-white w-32">
        <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-300 p-2 transition-colors">
            <i class="fas fa-trash-alt"></i>
        </button>
    `;
  container.appendChild(newSlot);
}

// Save availability
async function saveAvailability() {
  const days = [
    "monday",
    "tuesday",
    "wednesday",
    "thursday",
    "friday",
    "saturday",
    "sunday",
  ];
  const schedule = {};

  try {
    days.forEach((day) => {
      const toggle = document.getElementById(`${day}-toggle`);
      const container = document.getElementById(`${day}-slots-container`);
      const slots = [];

      if (toggle && toggle.checked && container) {
        const timeSlots = container.querySelectorAll(".time-slot");
        timeSlots.forEach((slot) => {
          const startInput = slot.querySelector(`input[name="${day}_start[]"]`);
          const endInput = slot.querySelector(`input[name="${day}_end[]"]`);

          if (startInput && endInput) {
            const start = startInput.value;
            const end = endInput.value;
            if (start && end) {
              slots.push([start, end]);
            }
          }
        });
      }

      schedule[day] = {
        active: toggle ? toggle.checked : false,
        slots: slots,
      };
    });

    const saveBtn =
      document.querySelector(".fa-save")?.closest("button") ||
      document.querySelector("button[onclick*='saveAvailability']");

    let originalText = "Save Changes";
    if (saveBtn) {
      originalText = saveBtn.innerHTML;
      saveBtn.disabled = true;
      saveBtn.innerHTML =
        '<i class="fas fa-spinner fa-spin"></i> <span>Saving...</span>';
    }

    // Try multiple ways to get the base URL
    const baseUrl =
      typeof BASE_URL !== "undefined"
        ? BASE_URL
        : window.location.origin + "/coachPro_MVC";

    console.log("Sending save request to:", baseUrl + "/coach/availability");

    const response = await fetch(baseUrl + "/coach/availability", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ schedule: schedule }),
    });

    if (!response.ok) {
      // If the absolute path failed (maybe BASE_URL is wrong), try relative path as fallback
      if (response.status === 404) {
        console.warn("Retrying with relative path...");
        const retryResponse = await fetch("availability", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ schedule: schedule }),
        });
        if (retryResponse.ok) {
          const result = await retryResponse.json();
          handleSaveResult(result, saveBtn, originalText);
          return;
        }
      }
      throw new Error(`Server responded with status ${response.status}`);
    }

    const result = await response.json();
    handleSaveResult(result, saveBtn, originalText);
  } catch (error) {
    console.error("Error saving availability:", error);
    alert("An unexpected error occurred: " + error.message);
    const saveBtn =
      document.querySelector(".fa-save")?.closest("button") ||
      document.querySelector("button[onclick*='saveAvailability']");
    if (saveBtn) {
      saveBtn.disabled = false;
      saveBtn.innerHTML =
        '<i class="fas fa-save"></i> <span>Save Changes</span>';
    }
  }
}

function handleSaveResult(result, saveBtn, originalText) {
  if (result.success) {
    alert("Availability settings saved successfully!");
  } else {
    alert("Error: " + result.message);
  }

  if (saveBtn) {
    saveBtn.disabled = false;
    saveBtn.innerHTML = originalText;
  }
}

function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebarOverlay");

  if (sidebar && sidebar.classList.contains("-translate-x-full")) {
    sidebar.classList.remove("-translate-x-full");
    overlay.classList.remove("hidden");
  } else if (sidebar) {
    sidebar.classList.add("-translate-x-full");
    overlay.classList.add("hidden");
  }
}
