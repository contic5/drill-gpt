<html lang="eng">
<head>
<link href="mystyle.css" type="text/css" rel="stylesheet">
<title>ChatGPT and PHP</title>
</head>
<body>
<main>
<h1>ChatGPT and PHP</h1>
<h2>Results</h2>
<p id="response">The response will show up here</p>
<h2>Setup</h2>
<form>
<label for="message_content">Enter your message here</label>
<textarea id="message_content" name="message_content" rows=6 cols=50>Hello</textarea>
<button onclick="make_request(event)" id="submitbutton">Submit</button>
</form>
</main>
    
<script>
function stream_message(responseText,location=0)
{
     document.getElementById("response").innerHTML = responseText.substring(0,location)
    if(location<responseText.length)
    {
        stream_function=setTimeout(
        function()
        {
            stream_message(responseText,location+1)
        },text_delay);
    };
}
function make_request(event) 
{
    event.preventDefault();
    let messages=[];
    let content=document.getElementById("message_content").value;
    messages.push({"role":"user","content":content});

    document.getElementById("response").innerHTML="Waiting for response...";
    document.getElementById("submitbutton").disabled=true;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("submitbutton").disabled=false;
            responseText=this.responseText;
            stream_function=setTimeout(
            function()
            {
                stream_message(responseText,0);
            },text_delay);
        }
    };

    const messagesJSON = JSON.stringify(messages);
    xmlhttp.open("GET", "getresponse.php?messages="+messagesJSON, true);
    xmlhttp.send();
}

let stream_function=null;
let text_delay=50;
stream_function=setTimeout(function()
{
    stream_message("Text will be streamed",0);
},text_delay);
</script>
</body>
