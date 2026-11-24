<?php
/*
 * Avisos de subida en el navegador (mu-plugin).
 * Para usuarios que no son administradores: explica por qué se rechaza un PNG, un vídeo
 * o un archivo de más de 15 MB. La regla real sigue en reglas-subida.php (servidor).
 */
function bs_avisos_subida() {
    static $hecho = false;
    if ($hecho || current_user_can('manage_options')) return;
    $hecho = true;
    $js = <<<'JS'
jQuery(function () {
  if (!window.wp || !wp.Uploader) return;
  var MAX = 15 * 1024 * 1024;
  function motivoTipo(f) {
    var n = ((f && f.name) || '').toLowerCase(), t = ((f && f.type) || '').toLowerCase();
    if (t === 'image/png' || /\.png$/.test(n)) return 'No se admiten imágenes PNG. Guarda la imagen como JPG y vuelve a subirla.';
    if (t.indexOf('video/') === 0 || /\.(mp4|mov|m4v|avi|wmv|webm|mkv|3gp|mpe?g|ogv)$/.test(n)) return 'No se admiten vídeos. Publícalo en YouTube o Vimeo e insértalo en la noticia.';
    return '';
  }
  if (wp.Uploader.errorMap) {
    var original = wp.Uploader.errorMap.FILE_EXTENSION_ERROR;
    wp.Uploader.errorMap.FILE_EXTENSION_ERROR = function (file) {
      var m = motivoTipo(file);
      if (m) return m;
      return typeof original === 'function' ? original.apply(this, arguments) : original;
    };
  }
  var init = wp.Uploader.prototype.init;
  wp.Uploader.prototype.init = function () {
    if (init) init.apply(this, arguments);
    if (!this.uploader) return;
    this.uploader.bind('FilesAdded', function (up, files) {
      for (var i = files.length - 1; i >= 0; i--) {
        if (files[i].size > MAX) {
          var mb = (files[i].size / 1048576).toFixed(1).replace('.', ',');
          wp.Uploader.errors.unshift({ message: 'El archivo pesa ' + mb + ' MB y el máximo es 15 MB. Redúcelo antes de subirlo.', data: {}, file: files[i] });
          up.removeFile(files[i]);
          files.splice(i, 1);
        }
      }
      if (!files.length) return false;
    }, null, 100);
  };
});
JS;
    wp_add_inline_script('wp-plupload', $js, 'after');
}
add_action('admin_enqueue_scripts', 'bs_avisos_subida', 20);
add_action('wp_enqueue_media', 'bs_avisos_subida', 20);
