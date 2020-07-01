@extends('customer.layouts.master')
    @section('content')
    <div class="tab-content dashboard_content">
<div class="wishlist_area mt-60">
    <div class="container">
        <form action="#">
            <div class="row">
                <div class="col-12">
                    <div class="table_desc wishlist">
                        <div class="wishlist-table table-responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th class="event-thumb gradient-pink-text">Image</th>
                                    <th class="supplier-name gradient-pink-text">Supplier Name</th>
                                    <th class="service-name gradient-pink-text">Service Name</th>
                                    <th class="price gradient-pink-text">Price Range</th>
                                    <th class="remove gradient-pink-text">Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="product_thumb"><a href="#"><img src=" alt=""></a></td>
                                    <td class="product_name"><a href="#">Handbag fringilla</a></td>
                                    <td class="product-price">£65.00</td>
                                    <td class="product_quantity">In Stock</td>
                                    <td class="product_remove"><a href="#"><i class="fas fa-trash"></i></a></td>


                                </tr>

                                <tr>
                                    <td class="product_thumb"><a href="#"><img src="" alt=""></a></td>
                                    <td class="product_name"><a href="#">Handbags justo</a></td>
                                    <td class="product-price">£90.00</td>
                                    <td class="product_quantity">In Stock</td>
                                    <td class="product_remove"><a href="#"><i class="fas fa-trash"></i></a></td>


                                </tr>
                                <tr>
                                    <td class="product_thumb"><a href="#"><img src="" alt=""></a></td>
                                    <td class="product_name"><a href="#">Handbag elit</a></td>
                                    <td class="product-price">£80.00</td>
                                    <td class="product_quantity">In Stock</td>
                                    <td class="product_remove"><a href="#"><i class="fas fa-trash"></i></a></td>


                                </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
    </div>

<style type="text/css">
.wishlist-table table{width: 100%;}
.table-responsive table tbody tr td {
    text-transform: uppercase;
    font-weight: normal;
    font-size: 12px;
}
    /*min-width: 150px;*/
.table_desc .wishlist-table table thead tr th {
/*    border-bottom: 3px solid #715dfc;
    border-right: 1px solid #ebebeb;*/
		padding: 0 0 4px 0;
		text-transform: uppercase;
 /*   text-align: center;*/
}
.table_desc .wishlist-table table tbody tr td {
    /* border-bottom: 1px solid #ebebeb; */
}
.table_desc .wishlist-table table tbody tr td a{font-size: 12px;}
</style>

@endsection
