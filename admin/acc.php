<fieldset>
    <legend>帳號管理</legend>
    <form action="api/admin_acc.php" method="post">
        <table style="width:50%;margin:auto">
        <tr class="ct clo">
            <td>帳號</td>
            <td>密碼</td>
            <td>刪除</td>
        </tr>
        <?php
        $db = new DB("user");
        $rows = $db->all();
        foreach ($rows as $row) {
        if($row['acc']!='admin'){   //管理者不顯示 避免被誤刪除

       

        ?>
            <tr class="ct">
                <td><?= $row['acc']; ?></td>
                <td><?= str_repeat("*",strlen($row['pw'])); ?></td>
                <td>
                    <input type="checkbox" name="del[]" value="<?= $row['id']; ?>">

                </td>
            </tr>

        <?php

    }
        }

        ?>

        </table>
    <div class="ct">
        <input type="submit" value="確定刪除">
        <input type="reset" value="清空選取">
    </div>
    </form>

    <h2>新增會員</h2>

    <form>
<table>
    <tr>
        <td colspan="2" style="color:red">
            *請設定您要註冊的帳號及密碼(最長12個字元)
        </td>
    </tr>
    <tr>
        <td width="50%" class="clo">
            Step1:登入帳號
        </td>
        <td width="50%"><input type="text" name="acc" id="acc"></td>
    </tr>
    <tr>
        <td class="clo">
            Step2:登入密碼</td>
        <td><input type="password" name="pw" id="pw"></td>
    </tr>
    <tr>
        <td class="clo">
            Step3:再次確認密碼</td>
        <td><input type="password" name="pw2" id="pw2"></td>
    </tr>
    <tr>
        <td class="clo">
            Step4:信箱(忘記密碼時使用)</td>
        <td><input type="text" name="email" id="email"></td>
    </tr>
    <tr>
        <td><input type="button" value="註冊" onclick="reg()"><input type="reset" value="清除"></td>
        <td></td>
    </tr>
</table>
</form>

</fieldset>

<script>

function reg(){
    //document.querySelector("#acc").value
    //先取得表單上輸入的資料
    let acc=$("#acc").val();
    let pw=$("#pw").val();
    let pw2=$("#pw2").val();
    let email=$("#email").val();

    //先判斷是否有欄位未填資料
    if(acc=="" || pw=="" || pw2=="" || email==""){
        alert("不可空白")
    }else{

        //檢查兩個密碼欄位是否一致
        if(pw==pw2){

            //先檢查帳號是否已被註冊
            $.get("api/chk_acc.php",{acc},function(res){
                if(res==='1'){
                    alert("帳號重覆")
                }else{

                    //確認為可註冊後將資料傳送到api去進行新增資料的動作,並產生相應的提示訊息
                    $.post("api/reg.php",{acc,pw,email},function(res){
                        if(res==='1'){
                            alert("註冊完成，歡迎加入")
                            location.reload();
                        }else{
                            alert("註冊失敗，請聯絡管理員")
                        }
                    })
                }
            })
        }else{
            alert("密碼錯誤")
        }
    }

}


</script>