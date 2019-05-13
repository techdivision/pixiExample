# PixiApiCustomize

## Events catalog export

### techdivision_pixi_export_catalog_check
The event is called before the catalog is exported and is used to implement an abort of the catalog export. see [ExportCatalogCheck](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportCatalogCheck.php) 

### techdivision_pixi_export_catalog_products_article_features
The event is called for every product item after standard &lt;FEATURE&gt; block vor pixi* to extend own attributes as &lt;ARTICLE_FEATURES&gt;. see [ExportCatalogArticleFeature](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportCatalogArticleFeature.php) 

### techdivision_pixi_export_catalog_products_article
The event is called after each product item to extend own XML block in &lt;ARTICLE&gt;. see [ExportCatalogProductsArticle](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportCatalogProductsArticle.php) 

### techdivision_pixi_export_catalog_products
The event is called after all products item to extend own XML block in &lt;T_NEW_CATALOG&gt;. see [ExportCatalogProducts](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportCatalogProducts.php) 

## Event order export
coming soon

## Stock import

### techdivision_pixi_import_stock_item_before_save
The event is called before stock item ist saved. see [ImportStockItemBeforeSave](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ImportStockItemBeforeSave.php) 

### techdivision_pixi_import_stock_product_before_save
The event is called before product item ist saved. see [ImportStockProductBeforeSave](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ImportStockProductBeforeSave.php) 
