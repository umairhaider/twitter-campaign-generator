var OPENAI_API_KEY = "<YOUR-API-KEY>";
var languageValue = "en-US";


function Send() {
    showLoader(true);
    var sQuestion = "Generate a tweet based on the provided text and don't add hashtags. The tweet should should be random, unique and it should be based on only on provided in this text: ";

    var oHttp = new XMLHttpRequest();
    oHttp.open("POST", "https://api.openai.com/v1/completions");
    oHttp.setRequestHeader("Accept", "application/json");
    oHttp.setRequestHeader("Content-Type", "application/json");
    oHttp.setRequestHeader("Authorization", "Bearer " + OPENAI_API_KEY)

    oHttp.onreadystatechange = function () {
        if (oHttp.readyState === 4) {
            //console.log("loaded successfully!");
            showLoader(false);
            var oJson = {}
            if (txtOutput.value != "") txtOutput.value += "\n";

            try {
                oJson = JSON.parse(oHttp.responseText);
            } catch (ex) {
                txtOutput.value += "Error: " + ex.message
            }

            if (oJson.error && oJson.error.message) {
                txtOutput.value += "Error: " + oJson.error.message;
            } else if (oJson.choices && oJson.choices[0].text) {
                var s = oJson.choices[0].text;

                if (languageValue != "en-US") {
                    var a = s.split("?\n");
                    if (a.length == 2) {
                        s = a[1];
                    }
                }

                if (s == "") s = "No response";
                txtOutput.value = s.replaceAll("\"", "") + hashtagTxt.value;
                
            }
        }
        else{
            showLoader(true);
        }
    };

    var sModel = "text-davinci-003";
    var iMaxTokens = 2048;
    var sUserId = "1";
    var dTemperature = 0.5;    

    var data = {
        model: sModel,
        prompt: sQuestion + txtMsg.value,
        max_tokens: iMaxTokens,
        user: sUserId,
        temperature:  dTemperature,
        frequency_penalty: 0.5, //Number between -2.0 and 2.0  Positive value decrease the model's likelihood to repeat the same line verbatim.
        presence_penalty: 0.5,  //Number between -2.0 and 2.0. Positive values increase the model's likelihood to talk about new topics.
        stop: ["#", ";"] //Up to 4 sequences where the API will stop generating further tokens. The returned text will not contain the stop sequence.
    }

    oHttp.send(JSON.stringify(data));
}

function Copy(){
    const newText = txtOutput.value;
    const textarea = document.createElement("textarea");
    textarea.value = newText.replace(/(\r\n|\n|\r)/gm, "");
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand("copy");
    textarea.remove();
    alert("Copied to clipboard");
}

function showLoader(item){
    var oLoader = document.getElementById("loaderItem");
    if(item){
        oLoader.classList.remove("hide");
    }
    else {
        oLoader.classList.add("hide");
    }
}