function showModal(tab) {
  modal_wrapper.style.display = "block";
  showTab(tab);
}

function hideModal() {
  modal_wrapper.style.display = "none";
}

function showTab(tab) {
  console.log(tab);
  Object.keys(tabs).forEach((e) => {
    const element = tabs[e];
    console.log(element);
    const content = document.getElementById(element.title);
    if (element.title === tab) {
      content.style.display = "block";
      element.style.backgroundColor = "white";
    } else {
      content.style.display = "none";
      element.style.backgroundColor = "";
    }
  });
}

const tabs = document.getElementById("tabs-bar").children;
console.log(tabs);
const modal_wrapper = document.getElementById("popup");
// modal_wrapper.addEventListener("click", (e) => {
//   hideModal();
// });
