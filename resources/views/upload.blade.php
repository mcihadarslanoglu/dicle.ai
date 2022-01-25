<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    @csrf
    
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="{{asset('/css/upload.css')}}" />
  </head>
  
  <body>
  @include('layouts.header')
    <div class="content">
      <div class = 'container'>
      <div class="layout">
        <div class="side">
          <ul class="list">
            <li>
              <a
                data-bs-toggle="collapse"
                href="#collapseExample"
                role="button"
                aria-expanded="false"
                aria-controls="collapseExample"
              >
                Folder1
              </a>
              <div class="collapse" id="collapseExample">
                <ul class="list">
                  <li>
                    <div class="folder-item">
                      <span class="title">Folder1-1</span>
                      <span class="actions">
                        <a href="#">edit</a>
                      </span>
                    </div>
                  </li>
                  <li>
                    <div class="folder-item">
                      <span class="title">Folder1-1</span>
                      <span class="actions">
                        <a href="#">edit</a>
                      </span>
                    </div>
                  </li>
                  <li>
                    <div class="folder-item">
                      <span class="title">Folder1-1</span>
                      <span class="actions">
                        <a href="#">edit</a>
                      </span>
                    </div>
                  </li>
                  <li>
                    <div class="folder-item">
                      <span class="title">Folder1-1</span>
                      <span class="actions">
                        <a href="#">edit</a>
                      </span>
                    </div>
                  </li>
                </ul>
              </div>
            </li>
            <li>
              <a
                data-bs-toggle="collapse"
                href="#collapseExample2"
                role="button"
                aria-expanded="false"
                aria-controls="collapseExample2"
              >
                Folder2
              </a>
              <div class="collapse" id="collapseExample2">
                <ul class="list">
                  <li>
                    <div class="folder-item">
                      <span class="title">Folder2-1</span>
                      <span class="actions">
                        <a href="#">edit</a>
                      </span>
                    </div>
                  </li>
                  <li>
                    <div class="folder-item">
                      <span class="title">Folder2-2</span>
                      <span class="actions">
                        <a href="#">edit</a>
                      </span>
                    </div>
                  </li>
                  <li>
                    <div class="folder-item">
                      <span class="title">Folder2-3</span>
                      <span class="actions">
                        <a href="#">edit</a>
                      </span>
                    </div>
                  </li>
                  <li>
                    <div class="folder-item">
                      <span class="title">Folder2-4</span>
                      <span class="actions">
                        <a href="#">edit</a>
                      </span>
                    </div>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
          <ul class="list">
            <li>
              <label><input type="checkbox" /> Show Only Folders</label>
            </li>
            <li>
              <label><input type="checkbox" /> Show Only Files</label>
            </li>
          </ul>
          <div>
            <button class="btn btn-primary" id="dosyaYukleBtn">
              Dosya Yükle
            </button>
            <input type="file" id="dosyaYukle" class="none" />
          </div>
        </div>
        <div class="main" id="main">
          <div class="path">
            <ul class="inline-list">
              <li>
                <a href="#">Folder1</a>
              </li>
              <li>
                <a href="#">Folder2</a>
              </li>
              <li>
                <a href="#">Folder3</a>
              </li>
              <li>
                <a href="#">Folder4</a>
              </li>
            </ul>
          </div>
          <div id="context" style="height: 100%">
            <div class="path_content">
              <a href="#" class="folder" data-id="folder1">folder</a>
              <a href="#" class="folder" data-id="folder2">folder</a>
              <a href="#" class="folder" data-id="folder3">folder</a>
              <a href="#" class="folder" data-id="folder4">folder</a>
              <a href="#" class="folder" data-id="folder5">folder</a>
              <a href="#" class="file" data-id="file1">File</a>
              <a href="#" class="file" data-id="file2">File</a>
              <a href="#" class="file" data-id="file3">File</a>
              <a href="#" class="file" data-id="file4">File</a>
              <a href="#" class="file" data-id="file5">File</a>
              <a href="#" class="file" data-id="file6">File</a>
              <a href="#" class="file" data-id="file7">File</a>
              <a href="#" class="file" data-id="file8">File</a>
              <a href="#" class="file" data-id="file9">File</a>
            </div>
            <input type="file" name="file" id="file" class="none" />
          </div>
        </div>
      </div>
    </div>
    </div>
    <ul id="menu-right-click">
      <li class="context-list rename">Adlandır</li>
      <li class="context-list delete">Sil</li>
    </ul>
    <ul id="menu-not-target">
      <li class="context-list add">Dosya Ekle</li>
    </ul>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
      integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
      integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>
    <script src= "{{asset('/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{ asset('/js/upload.js') }}"></script>
    
  </body>
</html>
