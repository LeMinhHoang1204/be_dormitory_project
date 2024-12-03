<link rel="stylesheet" href="{{ asset('./css/pagination.css') }}" type="text/css">
<div class="container">
    <ul class="pagination">
        <li><a href="#">Previous</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">6</a></li>
        <li><a href="#">7</a></li>
        <li><a href="#">8</a></li>
        <li><a href="#">Next</a></li>
    </ul>
</div>

<script>
    $("li").click(function() {
        $(this).addClass("active").siblings().removeClass("active");
    });
</script>
