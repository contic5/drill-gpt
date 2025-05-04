<html lang="eng">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Sriracha&display=swap" rel="stylesheet">
<link href="mystyle.css" type="text/css" rel="stylesheet">
<title>Drill GPT</title>
</head>
<body>
<main>
<h1>Drill GPT</h1>
<h2>About</h2>
<p>This is a webpage that lets you receive Taekwondo drill ideas from ChatGPT. 
You can set the parameters for the drill, such as belt level, curriculum focus and equipment.</p>
<h2>Results</h2>
<p id="response">The response will show up here</p>
<h2>Query</h2>
<p id="query">Your query to ChatGPT will show up here.</p>
<h2>Setup</h2>
<form>
<label for="text_delay">Text Delay</label>
<select id="text_delay" onchange="update_query_speed()">
<option value=100>Slow</option>    
<option value=50>Medium</option>   
<option value=25>Fast</option>    
<option value=10>Very Fast</option>  
<option value=1>Near Instant</option> 
<option value=0 selected>Instant</option>
</select>

<label for="belt_level">Belt Level</label>
<select id="belt_level" onchange="update_query()">
<option value="No Belt to Yellow Belt">No Belt to Yellow Belt</option>
<option value="Orange Belt to Blue Belt">Orange Belt to Blue Belt</option>
<option value="Purple Belt to Brown Belt">Purple Belt to Brown Belt</option>
<option value="Junior Black Belt">Junior Black Belt</option>
<option value="Black Belt">Black Belt</option>
</select>
    
<label for="age_range">Age Range</label>
<select id="age_range" onchange="update_query()">
<option value="children">Children</option>
<option value="teenagers">Teenagers</option>
<option value="adults">Adults</option>
</select>

<label for="exercise_area">Exercise Area</label>
<select id="exercise_area" onchange="update_query()">
<option value="Upper Body">Upper Body</option>    
<option value="Lower Body">Lower Body</option>   
</select>
<label for="equipment">Equipment</label>
<input id="equipment" list="equipment_datalist">
<datalist id="equipment_datalist" onchange="update_query()">
<option value="Hand Targets">Hand Targets</option>
<option value="Shield Targets">Shield Targets</option>
<option value="Ladder">Ladder</option>
<option value="Hula Hoops">Hula Hoops</option>
<option value="Heavy Bag">Heavy Bag</option>
<option value="No Equipment">No Equipment</option>
</datalist>

<label for="weekly_curriculum">Weekly Curriculum</label>
<select id="weekly_curriculum" onchange="update_query()">
<option value="Poomsae">Poomsae/Form</option>    
<option value="Breaking">Breaking</option>
<option value="Kicking Combinations">Kicking Combinations</option>    
<option value="Self Defense">Self Defense</option>
</select>

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
function update_query()
{
    belt_level=document.getElementById("belt_level").value;
    exercise_area=document.getElementById("exercise_area").value;
    equipment=document.getElementById("equipment").value;
    if(!equipment)
    {
        equipment="No Equipment";
    }
    weekly_curriculum=document.getElementById("weekly_curriculum").value;
    age_range=document.getElementById("age_range").value;
    query=`Give me a Taekwondo exercise drill for ${belt_level} students that focuses on ${exercise_area}, uses ${equipment} and will help for ${weekly_curriculum}. The drill should be for ${age_range}. Keep the explanation short (under 100 words). Use HTML tags since this will appear inside an HTML div.`;
    document.getElementById("query").innerHTML=query;
}
function update_query_speed()
{
    text_delay_element=document.getElementById("text_delay");
    text_delay=text_delay_element.value;
    
    text_delay_description=text_delay_element.options[text_delay_element.selectedIndex].text;
    
    handle_response(`The text display speed is ${text_delay_description}. The query response will display here.`);
}
function handle_response(responseText)
{
    if(text_delay>0)
    {
        stream_function=setTimeout(
        function()
        {
            stream_message(responseText,0);
        },text_delay);
    }
    else
    {
        document.getElementById("response").innerHTML=responseText;
    }
}
function make_request(event) 
{
    alert(query);
    event.preventDefault();
    let messages=[];
    messages.push({"role":"user","content":query});

    document.getElementById("response").innerHTML="Waiting for response...";
    document.getElementById("submitbutton").disabled=true;
    
    text_delay=parseInt(document.getElementById("text_delay").value);

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("submitbutton").disabled=false;
            responseText=this.responseText;
            handle_response(responseText);
        }
    };

    const messagesJSON = JSON.stringify(messages);
    xmlhttp.open("GET", "getresponse.php?messages="+messagesJSON, true);
    xmlhttp.send();
}

let belt_level=document.getElementById("belt_level").value;
let exercise_area=document.getElementById("exercise_area").value;
let equipment=document.getElementById("equipment").value;
let weekly_curriculum=document.getElementById("weekly_curriculum").value;
let age_range=document.getElementById("age_range").value;

let query="";
update_query();

let stream_function=null;
let text_delay=50;
let text_delay_description="Slow";
update_query_speed();
</script>
</body>
</html>