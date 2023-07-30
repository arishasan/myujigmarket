<div class="callout callout-success">
    <div class="row">
        <div class="col-lg-8">
            <h3 class="text-success"><b>{{ $data_promo->kode_promo }}</b></h3>
        </div>
        <div class="col-lg-4 text-right">
            <b class="{{ $data_promo->status == 1 ? 'text-success' : 'text-danger' }}">{{ $data_promo->status == 1 ? 'Aktif' : 'Non-Aktif' }}</b>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-lg-4">
            <b>Minimal Belanja</b><br>
            Rp. {{ number_format($data_promo->minimal_belanja) }}
        </div>
        <div class="col-lg-4">
            <b>Type Promo</b><br>
            {{ $data_promo->type_promo }}
        </div>
        <div class="col-lg-4">
            <b>Value Promo</b><br>
            {{ $data_promo->type_promo == 'Percentage' ? $data_promo->value_promo.'%' : "Rp. ".$data_promo->value_promo }}
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-12">
            <b>Periode Dari - Sampai</b><br>
            {{ date('d M Y', strtotime($data_promo->periode_mulai)) }} - {{ date('d M Y', strtotime($data_promo->periode_berakhir)) }}
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-lg-6">
            <b>Quota</b><br/>
            <h4 class="text-primary"><i class="fa fa-ticket-alt"></i> {{ $data_promo->quota }}</h4>
        </div>
        <div class="col-lg-6">
            <b>Digunakan</b><br/>
            <h4 class="text-success"><i class="fa fa-check"></i> 0</h4>
        </div>
    </div>

</div>