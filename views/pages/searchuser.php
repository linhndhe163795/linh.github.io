<style>
    .btn-secondary{
        position: absolute;
        left: 1150px;
    }
    .btn-danger{
        display: flex;
    }
</style>
<title>User - Search</title>
<?php
require_once './helper/const.php';
include 'header.php';
?>
<div class="container">
    <h2>Form Sreach</h2>
    <form action="/index.php?controller=search&action=searchUser" method="get">
        <input type="hidden" name="controller" value="search" />
        <input type="hidden" name="action" value="searchUser" />

        <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Email</span>
            </div>
            <input type="text" class="form-control" aria-label="Small" 
                   aria-describedby="inputGroup-sizing-sm" id="email" name="email" placeholder="Input email" value="<?php echo isset($email) ? $email : "" ?>">
        </div>
        <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm"> Name</span>
            </div>
            <input type="text" id="name" name="name" placeholder="Input name" 
                   class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="<?php echo isset($name) ? $name : "" ?>">
        </div>
        <button type="submit" name="searchuser" class="btn btn-primary">Search</button>
        <button type="button" onclick="ResetInput()" name = 'reset'class="btn btn-secondary">Reset</button>
        <div style="color: red"><?php echo isset($messages) ? $messages : " " ?></div>
    </form>

    <?php if (isset($list))  ?>
    <table style="width: 1100px" id='example2' class="  table table-center bg-white mb-0">

        <thead>
            <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th >Status</th>
                <th>Action</th>
            </tr>
        </thead>   
        <tbody>
            <?php
            if (isset($list)) {
                foreach ($list as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td><img alt="image" style="max-height: 100px; max-width: 100px" src="/views/pages/media/' . $row['avatar'] . '"></td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    if ($row['status'] == ACTIVE)
                        echo '<td> Active </td>';
                    if ($row['status'] == BAN)
                        echo '<td> Banned </td>';
                    echo '<td style="display:inline"><a href="index.php?controller=edit&action=loadDataEdit&id=' . $row['id'] . '"><button class="btn btn-success">Edit</button></a>';
                    echo
                    '<form id="delete" action="index.php?controller=edit&action=deleteUser&id=' . $row['id'] . '" method="POST">' .
                    '<input type="hidden" name="delete_account" id="deleteId" value="' . $row['id'] . '"/>' .
                    '<input type="hidden" name="del_flag" id="deleteId" value="' . $row['del_flag'] . '"/>' .
                    '<input type="button" class="btn btn-danger" id="delete" name="id" onclick="DeleteAccount(\'' . $row['id'] . '\')" value="Delete"/></td>' .
                    '</form>';
                    echo '</tr>';
                }
            }
            ?>

        </tbody>
    </table>
    <?php
    if (isset($number_of_page)) {
        $email = isset($_GET['email']) ? $_GET['email'] : '';
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        // Số trang trước và sau bạn muốn hiển thị
        $numPagesToShow = NUMBER_PAGE_TO_SHOW;

        echo '<nav aria-label="Page navigation example">';
        echo '<ul class="pagination">';
        // Hiển thị liên kết đến trang đầu
        if ($currentPage > 1) {
            echo '<li class="page-item">
            <a class="page-link" href="index.php?controller=search&action=searchUser&page=1'
            . '&name=' . urlencode($name) . ''
            . '&email=' . urlencode($email) . '" aria-label="Previous">
                <span aria-hidden="true">&laquo</span>
            </a>
        </li>';
        }
        // Liên kết trang trước
        if ($currentPage > 1) {
            echo '<li class="page-item">
            <a class="page-link" href="index.php?controller=search&action=searchUser&page=' . ($currentPage - 1) . ''
            . '&name=' . urlencode($name) . ''
            . '&email=' . urlencode($email) . '" aria-label="Previous">
                <span aria-hidden="true">Prev</span>
            </a>
        </li>';
        }

        // Liên kết trang
        for ($i = max(1, $currentPage - $numPagesToShow); $i <= min($number_of_page, $currentPage + $numPagesToShow); $i++) {
            if ($i == $currentPage) {
                echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="index.php?controller=search&action=searchUser&page=' . $i . ''
                . '&name=' . urlencode($name) . ''
                . '&email=' . urlencode($email) . '">' . $i . '</a></li>';
            }
        }

        // Liên kết trang sau
        if ($currentPage < $number_of_page) {
            echo '<li class="page-item">
            <a class="page-link" href="index.php?controller=search&action=searchUser&page=' . ($currentPage + 1) . ''
            . '&name=' . urlencode($name) . ''
            . '&email=' . urlencode($email) . '" aria-label="Next">
                <span aria-hidden="true">Next</span>
            </a>
        </li>';
        }
        // Hiển thị liên kết đến trang cuối
        if ($currentPage < $number_of_page) {

            echo '<li class="page-item">
            <a class="page-link" href="index.php?controller=search&action=searchUser&page=' . $number_of_page . ''
            . '&name=' . urlencode($name) . ''
            . '&email=' . urlencode($email) . '" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>';
        }

        echo '</ul>';
        echo '</nav>';
    }
    ?>
</div>
</body>


<script src="assets/js/delete_account.js"></script>
<script src="../../assets/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../../assets/js/jquery.dataTables.min.js"></script>
<script src="../../assets/js/dataTables.bootstrap.min.js"></script>

<script>
            $(function () {
                $('#example2').DataTable({
                    "paging": false,
                    "lengthChange": true,
                    "searching": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false
                });
            });
</script>
</html>
