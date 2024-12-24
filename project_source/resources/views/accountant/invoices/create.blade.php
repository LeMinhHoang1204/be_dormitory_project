 @extends('Auth_.index')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tạo hóa đơn mới</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('accountant.invoices.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="customer_name">Tên khách hàng <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="text" class="form-control" id="phone" name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="invoice_date">Ngày hóa đơn <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="invoice_date" name="invoice_date"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="due_date">Ngày đến hạn</label>
                                        <input type="date" class="form-control" id="due_date" name="due_date">
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_method">Phương thức thanh toán</label>
                                        <select class="form-control" id="payment_method" name="payment_method">
                                            <option value="cash">Tiền mặt</option>
                                            <option value="bank_transfer">Chuyển khoản</option>
                                            <option value="credit_card">Thẻ tín dụng</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <table class="table table-bordered" id="invoice_items">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm/Dịch vụ</th>
                                                <th>Mô tả</th>
                                                <th>Số lượng</th>
                                                <th>Đơn giá</th>
                                                <th>Thành tiền</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" class="form-control" name="items[0][name]"
                                                        required></td>
                                                <td><input type="text" class="form-control" name="items[0][description]">
                                                </td>
                                                <td><input type="number" class="form-control quantity"
                                                        name="items[0][quantity]" required></td>
                                                <td><input type="number" class="form-control price" name="items[0][price]"
                                                        required></td>
                                                <td><input type="number" class="form-control subtotal"
                                                        name="items[0][subtotal]" readonly></td>
                                                <td><button type="button"
                                                        class="btn btn-danger btn-sm remove-item">Xóa</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-info" id="add_item">Thêm sản phẩm</button>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6 offset-md-6">
                                    <table class="table">
                                        <tr>
                                            <td>Tổng tiền:</td>
                                            <td><input type="number" class="form-control" id="total_amount"
                                                    name="total_amount" readonly></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tổng cộng:</strong></td>
                                            <td><input type="number" class="form-control" id="grand_total"
                                                    name="grand_total" readonly></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <label for="notes">Ghi chú</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                            </div>

                            <div class="text-right mt-4">
                                <a href="{{ route('accountant.invoices.index') }}" class="btn btn-secondary">Hủy</a>
                                <button type="submit" class="btn btn-primary">Tạo hóa đơn</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Thêm dòng sản phẩm mới
                $('#add_item').click(function() {
                    let rowCount = $('#invoice_items tbody tr').length;
                    let newRow = `
                <tr>
                    <td><input type="text" class="form-control" name="items[${rowCount}][name]" required></td>
                    <td><input type="text" class="form-control" name="items[${rowCount}][description]"></td>
                    <td><input type="number" class="form-control quantity" name="items[${rowCount}][quantity]" required></td>
                    <td><input type="number" class="form-control price" name="items[${rowCount}][price]" required></td>
                    <td><input type="number" class="form-control subtotal" name="items[${rowCount}][subtotal]" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-item">Xóa</button></td>
                </tr>
            `;
                    $('#invoice_items tbody').append(newRow);
                });

                // Xóa dòng sản phẩm
                $(document).on('click', '.remove-item', function() {
                    $(this).closest('tr').remove();
                    calculateTotals();
                });

                // Tính toán thành tiền cho từng dòng
                $(document).on('input', '.quantity, .price', function() {
                    let row = $(this).closest('tr');
                    let quantity = parseFloat(row.find('.quantity').val()) || 0;
                    let price = parseFloat(row.find('.price').val()) || 0;
                    let subtotal = quantity * price;
                    row.find('.subtotal').val(subtotal);
                    calculateTotals();
                });

                // Tính tổng tiền (đã loại bỏ phần tính thuế)
                function calculateTotals() {
                    let total = 0;
                    $('.subtotal').each(function() {
                        total += parseFloat($(this).val()) || 0;
                    });

                    $('#total_amount').val(total);
                    $('#grand_total').val(total); // Tổng cộng giờ bằng tổng tiền vì không có thuế
                }
            });
        </script>
    @endpush
@endsection
