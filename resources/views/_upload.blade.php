<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Uplaod</title>
        <link href="{{ asset('css/_upload.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/right-click.css') }}" rel="stylesheet" />
        @csrf
    </head>
    <body>
        <section class="container">
            <div class="settings-div">settings-div</div>
            <div class="folders-div">
                <div class="folders-path-div">folders-path-div</div>
                <div class="folders-content-div" id="folders-content-div">
                    folders-content-div
                    <div class="folder">
                        <span class="folder-icon">icon</span>
                        <span class="folder-name">name</span>
                    </div>
                    <div class="folder">
                        <span class="folder-icon">icon</span>
                        <span class="folder-name">name</span>
                    </div>

                    <div class="folder">
                        <span class="folder-icon">icon</span>
                        <span class="folder-name">name</span>
                    </div>

                    <div class="folder">
                        <span class="folder-icon">icon</span>
                        <span class="folder-name">name</span>
                    </div>

                    folders-div
                </div>
                <div class="contextmenu" id="contextmenu">
                    <ul>
                        <li>Seçenek</li>
                        <li>Seçenek</li>
                        <li>Seçenek</li>
                        <li>Seçenek</li>
                    </ul>
                </div>
            </div>
        </section>

        <script src="{{ asset('js/right-click.js') }}"></script>
        <script src="{{ asset('js/_upload.js') }}"></script>
        <script>
            setTargetDiv("folders-content-div");
            setContextMenu("contextmenu");
            setContextMenuFunction();
            initFolderDiv("folders-content-div");
        </script>
    </body>
</html>
