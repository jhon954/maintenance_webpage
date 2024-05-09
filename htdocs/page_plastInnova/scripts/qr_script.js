let btn = document.querySelector(".qr");
let qr_code_element = document.querySelector(".qr-code");
let begin_path = "localhost/page_plastInnova/users/form_create_task.php"

btn.addEventListener("click", () => {
let user_input = document.querySelector('#url');
  if (user_input.value != "") {
    if (qr_code_element.childElementCount == 0) {
      generate(begin_path+user_input.value);
    } else {
      qr_code_element.innerHTML = "";
      generate(begin_path+user_input);
    }
    qr_code_element.style = "opacity: 1";
  } else {
    console.log("not valid input");
    qr_code_element.style = "display: none";
    qr_code_element.style = "opacity: 0";
  }
});

function generate(user_input) {
  qr_code_element.style = "";

  let qrcode = new QRCode(qr_code_element, {
    text: `${user_input}`,
    width: 180, //128
    height: 180,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
  });

  let download = document.createElement("button");
  qr_code_element.appendChild(download);

  let download_link = document.createElement("a");
  download_link.setAttribute("download", "qr_code.png");
  download_link.innerHTML = `Download`;

  download.appendChild(download_link);

  let qr_code_img = document.querySelector(".qr-code img");
  let qr_code_canvas = document.querySelector("canvas");

  if (qr_code_img.getAttribute("src") == null) {
    setTimeout(() => {
      download_link.setAttribute("href", `${qr_code_canvas.toDataURL()}`);
    }, 300);
  } else {
    setTimeout(() => {
      download_link.setAttribute("href", `${qr_code_img.getAttribute("src")}`);
    }, 300);
  }
}