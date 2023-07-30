<div class="row no-gutters">
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <!-- Product Slider -->
            <div class="product-gallery">
                <div class="quickview-slider-active">
                    <div class="single-slider">
                        <img src="{{ asset('') }}/{{ $produk->image }}" alt="#">
                    </div>
                </div>
            </div>
        <!-- End Product slider -->
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <input type="hidden" id="preview_id" name="preview_id" value="{{ $produk->id }}">
        <div class="quickview-content">
            <h2 style="color: #F7941D">{{ $produk->nama_produk }}</h2>
            <div class="quickview-ratting-review">
                <div class="quickview-ratting-wrap">
                    <div class="quickview-ratting">
                        {!! App\Models\HelperModel::getStars(App\Models\HelperModel::getReviewProduk('rate', $produk->id)) !!}
                        {{-- <i class="yellow fa fa-star"></i> --}}
                    </div>
                    <a href="#"> ({{ App\Models\HelperModel::getReviewProduk('count', $produk->id) }} customer review)</a>
                </div>
                <div class="quickview-stock">
                    <span>{!! $produk->stok <= 0 ? '<i class="fa fa-times text-danger"></i> Stok Habis' : '<i class="fa fa-check-circle-o"></i> Stok Tersedia' !!} <b>({{ number_format($produk->stok) }})</b></span>
                </div>
            </div>
            {{ $produk->nama_kategori }}
            @if($produk->is_promo == 1)
            <?php
                $potongan = ($produk->harga_jual * $produk->value_promo) / 100;
            ?>
            <h3>Rp. {{ number_format($produk->harga_jual - $potongan) }} <small style="color:grey; text-decoration: line-through">Rp. {{ number_format($produk->harga_jual) }}</small></h3>
            @else
            <h3>Rp. {{ number_format($produk->harga_jual) }}</h3>
            @endif
            <div class="quickview-peragraph">
                <p>{{ $produk->deskripsi }}</p>
            </div>
            <br/>
            Kondisi Barang : <b>{{ $produk->is_new == 1 ? 'Baru' : 'Bekas' }}</b><br/>
            Berat Barang (gram) : <b>{{ number_format($produk->berat_gram) }}g</b>
            <div class="size">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <h5 class="title">Catatan</h5>
                        <textarea name="catatan" id="preview_catatan" rows="2" class="form-control">{{ $produk->catatan }}</textarea>
                    </div>
                </div>
            </div>
            <div class="quantity">
                <!-- Input Order -->
                <div class="input-group">
                    {{-- <div class="button minus">
                        <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="qty">
                            <i class="ti-minus"></i>
                        </button>
                    </div> --}}
                    <input type="number" name="qty" id="preview_qty" class="input-number"  min="1" max="{{ $produk->stok }}" value="{{ $produk->qty }}">
                    {{-- <div class="button plus">
                        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="qty">
                            <i class="ti-plus"></i>
                        </button>
                    </div> --}}
                </div>
                <!--/ End Input Order -->
            </div>
            <div class="add-to-cart">
                <button type="button" class="btn" id="btn_add_cart" onclick="saveCart()">Simpan</a>
            </div>
            <div class="default-social">
                <h4 class="share-now">Share:</h4>
                <ul>
                    <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                    <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>