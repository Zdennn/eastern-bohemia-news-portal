<div class="body">
    <div class="container">
        <h1 class="oops">Oops!</h1>
        <h2>404 - STRÁNKA NENALEZENA</h2>
        <p>Stránka, kterou hledáte, mohla být odstraněna, přejmenována nebo je dočasně nedostupná.</p>
        <a href="/" class="btn">Zpět na hlavní stránku</a>
    </div>
</div>


<script>
    function adjustBodyHeight() {
        document.querySelector('.body').style.height = (window.innerHeight-274.5) + 'px';
    }

    window.addEventListener('resize', adjustBodyHeight);
    window.addEventListener('load', adjustBodyHeight);
</script>