<dl class="variation"><?php foreach ( $item_data as $data ): ?><?php $key = sanitize_text_field( $data['key'] ); ?><dt class="variation-<?php echo sanitize_html_class( $key );?>"><?php print wp_kses_post( $data['key'] ); ?>:</dt><dd class="print sanitize_html_class( $key );"><?php print wp_kses_post( wpautop( $data['value'] ) ); ?></dd><?php endforeach; ?></dl>