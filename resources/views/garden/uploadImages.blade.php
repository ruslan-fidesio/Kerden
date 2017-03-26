@extends ('garden.menu')

@section('contentPane')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-kerden-home">
                <div class="panel-heading">Images / Photos</div>
                <div class="panel-body">
                    Pour l'instant, Kerden ne permet pas d'uploader des photos de jardin via le site.<br/>
                    Nos photographes prendrons contact avec vous pour vous rencontrer, et mettre en valeur votre bien.
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $('.HPMenuLink').removeClass('active');
    $('.gardenMenu').addClass('active');

    $('.left-menu-link').removeClass('active');
    $('.left-menu-link:nth-child(7)').addClass('active');
    showPage2();
</script>
@endsection