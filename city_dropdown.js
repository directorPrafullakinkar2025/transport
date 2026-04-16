  document.getElementById("state").addEventListener("change", function () {

    const cityDropdown = document.getElementById("city");
    cityDropdown.innerHTML = '<option value="">Select City Name</option>';

    const selectedState = this.value;

    if (stateCities[selectedState]) {
      stateCities[selectedState].forEach(function (city) {
        const option = document.createElement("option");
        option.value = city;
        option.textContent = city;
        cityDropdown.appendChild(option);
      });
    }
  });




document.addEventListener("DOMContentLoaded", function () {

  const city = document.getElementById("city");
  const pin = document.getElementById("pincode");
  const std = document.getElementById("std_code");

  if (!city || !pin || !std) return;

  city.addEventListener("change", function () {

    pin.innerHTML = '<option value="">Select PIN Code</option>';
    std.innerHTML = '<option value="">Select STD Code</option>';

    if (cityPinStd[this.value]) {

      const pinOpt = document.createElement("option");
      pinOpt.value = cityPinStd[this.value].pin;
      pinOpt.textContent = cityPinStd[this.value].pin;
      pin.appendChild(pinOpt);

      const stdOpt = document.createElement("option");
      stdOpt.value = cityPinStd[this.value].std;
      stdOpt.textContent = cityPinStd[this.value].std;
      std.appendChild(stdOpt);
    }
  });

});
