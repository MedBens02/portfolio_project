document.addEventListener("DOMContentLoaded", function () {
  fetchCourses();
});

var PROF_ID = undefined;
document.getElementById("cours").addEventListener("change", function () {
  const selectedOption = this.options[this.selectedIndex];
  const profId = selectedOption.getAttribute("data-prof-id");
  PROF_ID = profId;
  fetchProfName(profId);
  loadChat(profId);
  try {
    clearInterval(chatPull);
  } catch {}
});

document.querySelector(".buttonAdd").addEventListener("click", function () {
  const payload = { recipientId: undefined, message: undefined };
  const input = document.querySelector(`input[name="message"]`);
  if (!input.value || input.value.trim() == "") {
    alert("insert a message first");
  } else {
    payload.message = input.value;
  }
  payload.recipientId = PROF_ID;
  console.log(payload);
  sendMessage(payload);
});

function fetchCourses() {
  const select = document.getElementById("cours");
  select.innerHTML += `<option value="" disabled selected>Cours</option>`;
  fetch("../../controllers/fetchMyCours.php")
    .then((response) => response.json())
    .then((data) => {
      select.innerHTML += data
        .map(
          (course) =>
            `<option data-prof-id="${course.prof_id}" name="${course.prof_id}" value="${course.id}">${course.nom}</option>`
        )
        .join("");
    });
}

function fetchProfName(profID) {
  const profName = document.getElementById("profName");
  const chatWith = document.getElementById("chatWith");
  fetch(`../../controllers/fetchProfName.php?profID=${profID}`)
    .then((response) => response.json())
    .then((data) => {
      profName.innerHTML = `${data.nom} ${data.prenom}`;
      chatWith.innerHTML = `Chat avec: <span>${data.nom} ${data.prenom}</span>`;
    });
}

function loadChat(secondParty) {
  fetch(
    `../../controllers/ChatController.php?method=get_chat_logs&secondParty=${secondParty}`
  )
    .then((response) => response.json())
    .then((res) => {
      const populateChat = ChatBuilder(secondParty);

      populateChat(res);
    });
}

function ChatBuilder(recipient_id) {
  return function PopulateChat(messagelogs) {
    const chatbox = document.querySelector(".chat-box");
    chatbox.innerHTML = ``;
    if (messagelogs.length === 0) {
      chatbox.innerHTML = `No Message Found`;
      return;
    }

    messagelogs.toReversed().forEach((message) => {
      const messageBlock = document.createElement("div");
      messageBlock.classList.add("msg-block");

      const textBlob = document.createElement("div");
      if (message.recipient_id == -1) {
        textBlob.classList.add("broadcast");
      } else {
        textBlob.classList.add(
          recipient_id == message.sender_id ? "received-msg" : "sent-msg"
        );
      }
      textBlob.setAttribute("data-time-stamp", message.time_stamp);
      textBlob.innerText = message.msg;
      var timepstamp = document.createElement("div");
      timepstamp.classList.add("time_stamp");
      timepstamp.innerText = message.time_stamp;
      textBlob.appendChild(timepstamp);
      messageBlock.appendChild(textBlob);
      chatbox.appendChild(messageBlock);
    });
  };
}

function sendMessage(payload) {
  if (!payload.message && !payload.recipientId) {
    alert("select a course and input text first");
    return;
  }
  fetch(
    `../../controllers/ChatController.php?method=send_message&secondParty=${payload.recipientId}`,
    { method: "POST", body: JSON.stringify({ message: payload.message }) }
  )
    .then((r) => {
      r.status;
    })
    .then((r) => {})
    .catch(console.log)
    .finally(() => {
      loadChat(payload.recipientId);
    });
}

document.addEventListener("DOMContentLoaded", function () {
  var chatPull = setInterval(() => {
    if (PROF_ID != undefined) {
      loadChat(PROF_ID);
    }
  }, 1000);
});
