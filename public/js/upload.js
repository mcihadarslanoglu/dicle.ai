(() => {
    let targetClickeList = null;

    const setUpEditFolderName = () => {
        let $elements = $(".folder-item").find(".actions > a");

        $elements.on("click", function (e) {
            let $parent = $(this).parents(".folder-item").first();
            let $title = $parent.find(".title");
            let title = $title.text();
            if ($(this).hasClass("active")) {
                // submit
                let input_val = $parent.find("input").val();
                $title.html(input_val);
                let $others = $(".folder-item").find(
                    ".actions > a:not(.active)"
                );
                $others.removeClass("none");
                $(this).text("edit");
                $(this).removeClass("active");
                // ajax with backend --
            } else {
                // edit
                $(this).addClass("active");
                // change text to ok
                $(this).text("Ok");
                // find others
                let $others = $(".folder-item").find(
                    ".actions > a:not(.active)"
                );
                $title.html(`
              <input type="text" value="${title}" />
            `);
                $others.addClass("none");
            }
        });
    };

    function enterClick(e) {
        let $target = $("#waitEnter");
        $target.on("keydown", function (e) {
            console.log(e.key);
            if (e.key === "Enter") {
                let newValue = $target.val();
                // start ajax call ...

                $target.parents("a").first().html(`${newValue}`);
            }
        });
    }

    function contextMenu() {
        $(document).on("contextmenu", "#context", function (e) {
            if (
                $(e.target).hasClass("folder") ||
                $(e.target).hasClass("file")
            ) {
                targetClickeList = $(e.target);
                $("#menu-right-click").css({
                    position: "absolute",
                    left: e.pageX,
                    top: e.pageY,
                    display: "block",
                });
                $("#menu-not-target").css({ display: "none" });
            } else {
                $("#menu-not-target").css({
                    position: "absolute",
                    left: e.pageX,
                    top: e.pageY,
                    display: "block",
                });
                $("#menu-right-click").css({ display: "none" });
            }
            return false;
        });
        $(document).on("click", function (e) {
            let $target = $(e.target);
            if ($target.hasClass("context-list")) {
                if ($target.hasClass("rename")) {
                    let currentValue = targetClickeList.text();
                    targetClickeList.html(
                        `<input type="text" id="waitEnter" value="${currentValue}" style="width:100%;" />`
                    );
                    enterClick();
                } else if ($target.hasClass("delete")) {
                    // start delete ajax
                    fetchData("url", "post", {
                        id: targetClickeList.attr("data-id"),
                    });
                } else if ($target.hasClass("add")) {
                    $("#file").trigger("click");
                }
                $target.parents("ul").first().css({ display: "none" });
            } else {
                $("#menu-right-click").css({
                    display: "none",
                });
                $("#menu-not-target").css({
                    display: "none",
                });
            }
        });
    }

    function initFileDrop() {
        $("#context").on("dragenter", function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (!$("#main").hasClass("drop-active")) {
                $("#main").addClass("drop-active");
            }
        });
        $("#context").on("dragleave", function (e) {
            e.preventDefault();
            e.stopPropagation();
            if ($("#main").hasClass("drop-active")) {
                $("#main").removeClass("drop-active");
            }
        });
        $("#context").on("drop", function (e) {
            if (e.originalEvent.dataTransfer) {
                if (e.originalEvent.dataTransfer.files.length) {
                    e.preventDefault();
                    e.stopPropagation();
                    /*UPLOAD FILES HERE*/
                    upload(e.originalEvent.dataTransfer.files);
                }
            }
        });
    }

    function fileInputListener() {
        $("#file").on("change", function (e) {
            let files = $(e.target)[0].files;
            upload(files);
        });
    }

    function upload(files) {
        alert("Upload " + files.length + " File(s).");
        // ajax call will work here
        fetchData("url", "post", { files });
    }

    const fetchData = async (url, method, data) => {
        const data_ = await $.ajax({
            url: url ? url : "./fakeFolders.json",
            method: method ? method : "get",
            contentType: "json",
            data: data,
            success: function (data) {},
            error: function () {
                alert("Something went wrogn !");
            },
        });
        return data_;
    };

    // start loading
    $("#main").html(`
    <h2>Loading ...</h2>
  `);
    fetchData().then((res) => {
        let template = `
    <div class="path">
    <ul class="inline-list">
    ${(() => {
        let tem = res?.path?.map((item) => {
            return `<li>
            <a href="${item.id}">${item.title}</a>
          </li>`;
        });
        return tem.join("");
    })()}
    </ul>
  </div>
  <div id="context" style="height: 100%">
    <div class="path_content">
    ${(() => {
        let tem = res?.folders?.map(
            (item) =>
                `
            <a 
              href="${item?.type === 0 ? item.id : "#"}"
              class="${item?.type === 0 ? "folder" : "file"}"
              data-id="${item?.id}"
            >
              ${item.name}
            </a>
          `
        );
        return tem.join("");
    })()}
    </div>
    <input type="file" name="file" id="file" class="none" />
  </div>
    `;
        // append data
        $("#main").html(template);
    });

    // dosya yükle button
    $("#dosyaYukleBtn").on("click", function (e) {
        $("#dosyaYukle").trigger("click");
    });

    $("#dosyaYukle").on("change", async function (e) {
        //console.log("e.target.files");
        //console.log(e.target.files[0]);
        let formData = new FormData();
        //formData.enctype = "multipart/form-data";
        formData.append("dosya", e.target.files[0]);
        //formData = "std";
        /*
        xml = new XMLHttpRequest();
        xml.open("POST", "upload");
        xml.setRequestHeader(
            "X-CSRF-TOKEN",
            document.getElementsByName("_token")[0].value
        );
        xml.onload = function () {
            console.log(xml.response);
        };
        xml.send(formData);
        // fetchData("url", "post", formData);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": document.getElementsByName("_token")[0].value,
            },
        });
        */
        token = document.getElementsByName("_token")[0].value;
        console.log(token);
        await $.ajax({
            headers: {
                "X-CSRF-TOKEN": token,
                data: formData,
            },
            url: "upload",
            method: "POST",
            contentType: "application/json; charset=utf-8",
            data: { formData: formData },
            processData: false,

            success: function (data, textStatus, xhr) {
                console.log(data);
                console.log(xhr.status);
            },
            error: function () {
                alert("Something went wrogn !");
            },
        });
    });

    initFileDrop();

    fileInputListener();

    contextMenu();

    setUpEditFolderName();
})();
