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
        
        <input type="hidden" id="transaksi_id" name="transaksi_id" value="{{ $trx }}">
        <input type="hidden" id="produk_id" name="produk_id" value="{{ $prod }}">
        <input type="hidden" name="id_review" value="{{ $is_new }}">

        <div class="quickview-content">
            <h2 style="color: #F7941D">{{ $produk->nama_produk }}</h2>
            <div class="quickview-peragraph">
                <p>{{ $produk->deskripsi }}</p>
            </div>
            <div class="size">
                <div class="row">
                    <div class="col-lg-12 col-12">

                        <style>
                            .star-rating {
                                direction: rtl;
                                display: inline-block;
                                padding: 20px;
                                cursor: default;
                            }
                            
                            input[type="radio"] {
                                display: none;
                            }
                        
                            label {
                                color: #bbb;
                                font-size: 2rem;
                                padding: 0;
                                cursor: pointer;
                                -webkit-transition: all 0.3s ease-in-out;
                                transition: all 0.3s ease-in-out;
                            }
                        
                            label:hover,
                            label:hover ~ label,
                            input[type="radio"]:checked ~ label {
                                color: #f2b600;
                            }
                        </style>

                        <b>Rate</b> <br/>
                        <div class="star-rating">
                            <input id="star-5" type="radio" name="rating" value="5" {{ @$review->rate == '5' ? 'checked' : '' }} />
                            <label for="star-5" title="5 stars">
                            <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                            <input id="star-4" type="radio" name="rating" value="4" {{ @$review->rate == '4' ? 'checked' : '' }} />
                            <label for="star-4" title="4 stars">
                            <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                            <input id="star-3" type="radio" name="rating" value="3" {{ @$review->rate == '3' ? 'checked' : '' }} />
                            <label for="star-3" title="3 stars">
                            <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                            <input id="star-2" type="radio" name="rating" value="2" {{ @$review->rate == '2' ? 'checked' : '' }} />
                            <label for="star-2" title="2 stars">
                            <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                            <input id="star-1" type="radio" name="rating" value="1" {{ @$review->rate == '1' ? 'checked' : '' }} />
                            <label for="star-1" title="1 star">
                            <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <b>Review</b><br/>
                        <textarea name="catatan" rows="2" class="form-control">{{ $review->catatan ?? '' }}</textarea>
                    </div>
                </div>
            </div>
            <div class="add-to-cart">
                <button type="submit" class="btn"><i class="fa fa-save"></i> Simpan Review</button>
            </div>
        </div>
    </div>
</div>