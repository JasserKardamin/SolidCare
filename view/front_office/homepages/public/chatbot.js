const sendChatBtn = document.querySelector(".chat_input span");
const chatinput = document.querySelector(".chat_input textarea");
const chatbox = document.querySelector(".chat_box");
const toggler = document.querySelector(".toggler");

let userMessage;
const inputinithieght = chatinput.scrollHeight ; 
const API_KEY = "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" ; 


const createchatli = (message, classname) => {
    // bot message handeling 
    const chatli = document.createElement("li")  ; 
    chatli.classList.add("chat", classname) ;
    let chatcontent = classname === "outgoing" ? `<p></p>` : ` <span class="material-symbols-outlined">smart_toy</span><p></p>`; 
    chatli.innerHTML = chatcontent ; 
    chatli.querySelector("p").textContent = message ; 
    return chatli ; 
}

const generateresponse =  (incomingChatLi) =>{
    const API_URL = "https://api.openai.com/v1/chat/completions" ;
    const messagElement = incomingChatLi.querySelector("p") ; 
    const requesanswer = {  
        method : "POST",
        headers : {
            "Content-Type": "application/json",
            "Authorization": `Bearer ${API_KEY}`
        },
        body: JSON.stringify({
            model: "gpt-3.5-turbo",
            messages: [{"role": "user",  "content": userMessage}]
        })
    }

    //send request and get answer with api from gpt
    fetch(API_URL,requesanswer).then(res => res.json()).then(data=>{
        messagElement.textContent = data.choices[0].message.content ; 
    }).catch((error)=>{
        messagElement.textContent = "Oops! Something went wrong. Please try again." ;  
    }).finally(() => chatbox.scrollTo(0,chatbox.scrollHeight)) ; 
}

const handleChat = () => {
    userMessage = chatinput.value.trim();
    if(!userMessage) return ;
    chatinput.value = "" ; 
    //handle user message : 
    chatbox.appendChild(createchatli(userMessage, "outgoing")) ;  
    chatbox.scrollTo(0,chatbox.scrollHeight) ;
    setTimeout(()=>{
        
        // handle delays    : 
        const incomingChatLi = createchatli("thinking...", "incoming")
        chatbox.appendChild(incomingChatLi) ;  
        chatbox.scrollTo(0,chatbox.scrollHeight) ;
         generateresponse(incomingChatLi) ; 
     },600) 
};

chatinput.addEventListener("input",() => {
    chatinput.style.height = `${inputinithieght}px` ; 
    chatinput.style.height = `${chatinput.scrollHeight}px`
})

chatinput.addEventListener("keydown", (e)=>{
    if( e.key === "Enter" && !e.shiftKey && window.innerWidth > 800)
    {
        e.preventDefault() ; 
        handleChat() ; 
    }
});


sendChatBtn.addEventListener("click", handleChat);
toggler.addEventListener("click",() => document.body.classList.toggle("show_bot"));
