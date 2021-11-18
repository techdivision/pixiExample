# PixiApiCustomize

## Catalog

### techdivision_pixi_export_catalog_product_collection
The event is called before all products item loaded to extend product information. see [ExportCatalogProductCollection](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportCatalogProductCollection.php)

### techdivision_pixi_export_catalog_check
The event is called before the catalog is exported and is used to implement an abort of the catalog export. see [ExportCatalogCheck](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportCatalogCheck.php) 

### techdivision_pixi_export_catalog_products_article_features
The event is called for every product item after standard &lt;FEATURE&gt; block vor pixi* to extend own attributes as &lt;ARTICLE_FEATURES&gt;. see [ExportCatalogArticleFeature](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportCatalogArticleFeature.php) 

### techdivision_pixi_export_catalog_products_article
The event is called after each product item to extend own XML block in &lt;ARTICLE&gt;. see [ExportCatalogProductsArticle](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportCatalogProductsArticle.php) 

### techdivision_pixi_export_catalog_products
The event is called after all products item to extend own XML block in &lt;T_NEW_CATALOG&gt;. see [ExportCatalogProducts](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportCatalogProducts.php) 

## Order

### techdivision_pixi_export_order_before
see [ExportOrderBefore](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportOrderBefore.php)

### techdivision_pixi_export_order_item_before
see [ExportOrderItemBefore](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportOrderItemBefore.php)

### techdivision_pixi_export_order_item_after
see [ExportOrderItemAfter](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportOrderItemAfter.php)

### techdivision_pixi_export_order_after
see [ExportOrderAfter](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ExportOrderAfter.php)

### techdivision_pixi_import_order_status_after
The event is called after import order status is saved. see [ImportOrderStatusAfter](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ImportOrderStatusAfter.php) 

## Stock

### techdivision_pixi_import_stock_item_before_save
The event is called before stock item ist saved. see [ImportStockItemBeforeSave](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ImportStockItemBeforeSave.php) 

### techdivision_pixi_import_stock_product_before_save
The event is called before product item ist saved. see [ImportStockProductBeforeSave](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/ImportStockProductBeforeSave.php) 


## Examples support 3rd-party modules
We have implemented an example of how to support the payment method PayPal PLUS - Pay upon invoice.   
In the example you will find an Order-Export-After-Observer which prepares and transfers the bank data for Pixi in the case of purchase on invoice.
[IWaysPayPalPlusExportOrderAfter](https://github.com/techdivision/pixiExample/blob/master/PixiApiCustomize/Observer/IWaysPayPalPlusExportOrderAfter.php) 
