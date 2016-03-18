<!DOCTYPE html>
<html>
<script src="/js/jspdf.js"></script>
<script src="/js/home.js"></script>
<body>
<div>
    <form>
        Job Name:<br>
        <input type="text" id="jobname">
        <br>
        Date:<br>
        <input type="text" id="date">
        <br> Job Address:<br>
        <input type="text" id="jobaddress">
        <br>Office/Home:<br>
        <input type="text" id="home">
        <br> Contact:<br>
        <input type="text" id="contact">
    </form>
</div>
<br>
{{ var_dump($stylegroup) }}
<hr>
{{ var_dump($stylegroup->job) }}
<hr>
{{ var_dump($stylegroup->job->lead) }}
<div>
    <input type="button" value="Create PDF" onclick="process()" />
</div>
</body>
</html>